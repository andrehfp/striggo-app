<?php

namespace App\Services;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use OpenAI;
use Illuminate\Support\Facades\Log;

class AITutorService
{
    private $client;

    public function __construct(
        private ContextBuilderService $contextBuilder
    ) {
        // Initialize OpenAI client
        $apiKey = config('services.openai.api_key');

        if ($apiKey) {
            $this->client = OpenAI::client($apiKey);
        }
    }

    /**
     * Send a message to the AI tutor and get a response
     */
    public function chat(Conversation $conversation, string $userMessage): string
    {
        if (!$this->client) {
            return 'Desculpe, o tutor de IA não está configurado no momento. Por favor, configure a chave da API OpenAI.';
        }

        try {
            // Save user message
            Message::createUserMessage($conversation, $userMessage);

            // Build conversation history
            $messages = $this->buildConversationHistory($conversation);

            // Call OpenAI API
            $response = $this->client->chat()->create([
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => $messages,
                'max_tokens' => config('services.openai.max_tokens', 500),
                'temperature' => config('services.openai.temperature', 0.7),
            ]);

            $assistantMessage = $response->choices[0]->message->content;

            // Save assistant message
            Message::createAssistantMessage($conversation, $assistantMessage, [
                'model' => $response->model,
                'usage' => $response->usage->toArray(),
            ]);

            return $assistantMessage;

        } catch (\Exception $e) {
            Log::error('AI Tutor error: ' . $e->getMessage(), [
                'conversation_id' => $conversation->id,
                'user_message' => $userMessage,
            ]);

            return 'Desculpe, ocorreu um erro ao processar sua mensagem. Por favor, tente novamente.';
        }
    }

    /**
     * Build conversation history for OpenAI API
     */
    private function buildConversationHistory(Conversation $conversation): array
    {
        $user = $conversation->user;
        $messages = [];

        // Add system prompt with user context
        $systemPrompt = $this->createSystemPrompt($user);
        $messages[] = [
            'role' => 'system',
            'content' => $systemPrompt,
        ];

        // Add recent messages (limit to last 10 to control costs)
        $recentMessages = $conversation->messages()
            ->latest()
            ->take(10)
            ->get()
            ->reverse()
            ->values();

        foreach ($recentMessages as $message) {
            if ($message->role !== 'system') {
                $messages[] = [
                    'role' => $message->role,
                    'content' => $message->content,
                ];
            }
        }

        return $messages;
    }

    /**
     * Create system prompt with user context
     */
    private function createSystemPrompt(User $user): string
    {
        $userContext = $this->contextBuilder->buildUserContext($user);

        $prompt = <<<PROMPT
Você é um tutor de IA amigável e prestativo para estudantes que estão praticando questões.

{$userContext}

SUAS RESPONSABILIDADES:
1. Explicar por que respostas estão corretas ou incorretas de forma clara e didática
2. Esclarecer conceitos e responder perguntas de acompanhamento
3. Fornecer recomendações de estudo baseadas nas áreas fracas do aluno
4. Responder perguntas gerais sobre o conteúdo estudado
5. Ser encorajador e motivador

DIRETRIZES:
- Seja sempre encorajador e positivo
- Explique conceitos de forma clara, com exemplos quando apropriado
- Ao explicar erros, primeiro reconheça o esforço do aluno
- Sugira tópicos específicos para estudar baseado nas áreas fracas
- Mantenha respostas concisas mas completas (máximo 3-4 parágrafos)
- Use português brasileiro
- Quando relevante, relacione o conteúdo com situações práticas
- Se o aluno pedir para explicar uma resposta errada, seja específico sobre onde estava o erro
- Encoraje o aluno a fazer mais perguntas se algo não estiver claro

ESTILO:
- Amigável e acessível
- Educativo mas não condescendente
- Motivador e encorajador
- Focado em ajudar o aluno a realmente entender, não apenas decorar
PROMPT;

        return $prompt;
    }

    /**
     * Get initial greeting for a new conversation
     */
    public function getInitialGreeting(User $user): string
    {
        $progress = $user->getOrCreateProgress();
        $gamificationService = app(GamificationService::class);
        $weakCategories = $gamificationService->getWeakestCategories($user, 1);

        $greeting = "Olá, {$user->name}! 👋 Sou seu tutor de IA e estou aqui para ajudar você a aprender melhor.\n\n";

        if (!empty($weakCategories)) {
            $weakCategory = $weakCategories[0]['category'];
            $accuracy = $weakCategories[0]['accuracy'];
            $greeting .= "Vejo que você está com {$accuracy}% de acerto em {$weakCategory}. Que tal focarmos nisso?\n\n";
        }

        $greeting .= "Como posso ajudar você hoje? Pode me perguntar sobre:\n";
        $greeting .= "- Explicações de questões que você errou\n";
        $greeting .= "- Conceitos que você quer entender melhor\n";
        $greeting .= "- Sugestões de como melhorar seu desempenho\n";
        $greeting .= "- Qualquer dúvida sobre o conteúdo!";

        return $greeting;
    }
}
