<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use App\Services\AITutorService;
use Illuminate\Support\Facades\Auth;

class AITutor extends Component
{
    public bool $isOpen = false;
    public string $userInput = '';
    public bool $isLoading = false;
    public ?int $conversationId = null;
    public array $messages = [];

    protected AITutorService $aiTutorService;

    public function boot(AITutorService $aiTutorService)
    {
        $this->aiTutorService = $aiTutorService;
    }

    public function mount()
    {
        $this->loadOrCreateConversation();
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;

        if ($this->isOpen) {
            $this->loadMessages();
        }
    }

    public function sendMessage()
    {
        if (empty(trim($this->userInput))) {
            return;
        }

        $this->isLoading = true;
        $userMessage = trim($this->userInput);
        $this->userInput = '';

        try {
            $conversation = Conversation::findOrFail($this->conversationId);

            // Get AI response
            $response = $this->aiTutorService->chat($conversation, $userMessage);

            // Reload messages
            $this->loadMessages();

        } catch (\Exception $e) {
            \Log::error('AI Tutor error in Livewire: ' . $e->getMessage());
            session()->flash('error', 'Ocorreu um erro ao enviar a mensagem.');
        } finally {
            $this->isLoading = false;
        }
    }

    public function startNewConversation()
    {
        $user = Auth::user();
        $currentConversation = Conversation::find($this->conversationId);

        if ($currentConversation) {
            $newConversation = $currentConversation->startNew();
        } else {
            $newConversation = Conversation::create([
                'user_id' => $user->id,
                'is_active' => true,
            ]);
        }

        $this->conversationId = $newConversation->id;
        $this->loadMessages();

        // Add initial greeting
        $greeting = $this->aiTutorService->getInitialGreeting($user);
        Message::createAssistantMessage($newConversation, $greeting);
        $this->loadMessages();
    }

    private function loadOrCreateConversation()
    {
        $user = Auth::user();
        $conversation = Conversation::getOrCreateForUser($user);

        $this->conversationId = $conversation->id;

        // If conversation has no messages, add initial greeting
        if ($conversation->messages()->count() === 0) {
            $greeting = $this->aiTutorService->getInitialGreeting($user);
            Message::createAssistantMessage($conversation, $greeting);
        }

        $this->loadMessages();
    }

    private function loadMessages()
    {
        if (!$this->conversationId) {
            return;
        }

        $conversation = Conversation::with('messages')->find($this->conversationId);

        if ($conversation) {
            $this->messages = $conversation->messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'role' => $message->role,
                    'content' => $message->content,
                    'created_at' => $message->created_at->format('H:i'),
                ];
            })->toArray();
        }
    }

    public function render()
    {
        return view('livewire.ai-tutor');
    }
}
