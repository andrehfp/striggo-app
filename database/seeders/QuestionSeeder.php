<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('questions.json'));
        $questions = json_decode($json, true);

        // Explicações pedagógicas para as questões
        $explicacoes = $this->getExplicacoes();

        foreach ($questions as $q) {
            Question::create([
                'numero' => $q['numero'],
                'enunciado' => $q['enunciado'],
                'opcao_a' => $q['opcao_a'],
                'opcao_b' => $q['opcao_b'],
                'opcao_c' => $q['opcao_c'],
                'opcao_d' => $q['opcao_d'],
                'resposta_correta' => $q['resposta_correta'],
                'explicacao' => $explicacoes[$q['numero']] ?? null,
                'categoria' => $q['categoria'],
                'prova_tipo' => 'tipo_1',
            ]);
        }
    }

    private function getExplicacoes(): array
    {
        return [
            1 => 'Ambas as definições iniciam categorizando a contabilidade como "ciência", palavra de conteúdo geral. Teórica/prática são complementares (não antônimas), os exemplos entre parênteses são ilustrativos, e as definições têm focos diferentes.',
            2 => 'A substituição correta é "escreveu" (verbo) → "redator" (substantivo). Erros: "criador" distorce "descobriu", "navegadoras" é adjetivo, "ocorrente" é inadequado.',
            3 => 'Payback descontado calcula quando os fluxos de caixa trazidos a valor presente igualam o investimento. Ano 1: 110k, Ano 2: 100k (total 210k). Faltam 90k do ano 3, que vale ≈110k descontado. Payback entre 2-3 anos.',
            4 => 'Usa-se a fórmula de anuidade (série de pagamentos iguais): PMT = PV / [(1-(1+i)^-n)/i]. Com PV=14.560, i=20%, n=3: PMT ≈ R$ 6.912. Fundamental em matemática financeira.',
            5 => 'A Lei 14.133/2021 lista expressamente no Art. 5º: impessoalidade, transparência e probidade administrativa. "Racionalidade econômica" não consta como princípio expresso na lei.',
            6 => 'CTN Art. 3º define tributo como prestação pecuniária COMPULSÓRIA, EM MOEDA, que NÃO constitua sanção de ato ilícito, instituída EM LEI, cobrada mediante atividade PLENAMENTE VINCULADA (sem discricionariedade).',
            7 => 'LC 123/2006: ME tem receita bruta anual até R$ 360mil, EPP de R$ 360mil até R$ 4,8 milhões. Estes limites são fundamentais para enquadramento no Simples Nacional.',
            8 => 'NBC PG 01: é ético expor conhecimento técnico com artigos/estudos. Vedado: promessas garantidas sem embasamento, crítica a concorrentes, divulgação de clientes sem autorização.',
            9 => 'NBC PG 100: clareza na exposição é habilidade essencial do contador. Dados corretos mas incompreensíveis não cumprem o objetivo de informar e assessorar o cliente.',
            10 => 'Neutralidade permite prudência (conservadorismo moderado). Uma informação neutra não pode ser parcial, tendenciosa ou ter inclinações que beneficiem determinado grupo.',
            11 => 'NBC TG Estrutura Conceitual: demonstrações devem fornecer informações comparativas de pelo menos um período anterior para identificar tendências. Essência sobre forma, estimativas são necessárias.',
            12 => 'Passivo aumenta em: compra a prazo (5k), receita antecipada (10k) e salários a pagar (12k) = R$ 27.000. Regime de competência reconhece obrigações independente do pagamento.',
            13 => 'FALSO: usar mesmas bases melhora comparabilidade. VERDADEIRO: mudança pode reduzir compreensibilidade mas ser justificada. VERDADEIRO: verificação é melhorada com bases observáveis.',
            14 => 'Propriedade para Investimento: terreno/edifício (NÃO veículo) para aluguel/valorização, classificado no ANC Investimentos (NÃO circulante), mensurado inicialmente pelo custo. Afirmativas II e III corretas.',
            15 => 'NBC TG 31: ativos reclassificados como mantidos para venda PARAM de depreciar. Reconhece-se pelo menor entre valor contábil e valor justo líquido de despesas de venda.',
            16 => 'Valor em uso reflete: estimativas de fluxos de caixa futuros, variações possíveis, e valor do dinheiro no tempo (taxa de desconto). NÃO inclui o custo histórico de aquisição.',
            17 => 'Goodwill gerado internamente não pode ser reconhecido. Logo, qualquer reversão de perda seria equivalente a reconhecer goodwill interno, o que é vedado pelas normas.',
            18 => 'DVA: FGTS = Pessoal (1), Aluguéis = Remuneração capital terceiros (3), Dividendos = Remuneração capital próprio (4), CSLL = Impostos (2). Sequência correta: 1-3-4-2.',
            19 => 'Valor depreciável em 01/01/2024: R$ 230.000 (350k - 4 anos × 30k). Revisão: 9 anos remanescentes. Nova depreciação: 230k / 9 = R$ 30.000 aproximadamente.',
            20 => 'FALSO: ativo é recurso PRESENTE (não precisa ser propriedade). FALSO: passivo é obrigação PRESENTE. VERDADEIRO: receitas aumentam PL. VERDADEIRO: despesas reduzem PL.',
            21 => 'Goodwill = Preço (1.300k) - 80% × VJ (1.200k) = 100k. Mais-valia = 80% × (VJ 1.500k - VC 1.000k) = 400k. Registra-se goodwill de 100k e mais-valia de 400k.',
            22 => 'NBC TG 18: influência significativa evidenciada por: representação nos órgãos, operações materiais, intercâmbio de pessoal, fornecimento de informação técnica, dependência técnica. "Indicação de funcionários" NÃO é critério.',
            23 => 'CMV = EI + Compras - Dev.Compras - EF = 3.000 + 5.000 - 500 - 2.000 = R$ 5.500. Fórmula fundamental de custos de mercadorias.',
            24 => 'NBC TG 25: provisionam-se apenas obrigações com saída PROVÁVEL de recursos. Se remota ou possível, apenas divulga em notas. Valor reconhecido: soma das obrigações prováveis.',
            25 => 'Não registrar receita de serviços prestados: SUBESTIMA receita, SUBESTIMA lucro, SUBESTIMA clientes. NÃO afeta disponível (caixa não foi recebido mesmo). Lucro fica subavaliado.',
            26 => 'Custo Médio Ponderado Móvel recalcula a cada compra. Cálculo detalhado: após cada transação, divide valor total por quantidade total. Estoque final: aproximadamente R$ 8.326.',
            27 => 'Fluxo operacional = Recebimentos vendas (200k) - Compra estoque (80k) - Aluguel semestre (30k) - Aluguel antecipado (18k) - Despesas (12k) = 60k. Depreciação NÃO é caixa.',
            28 => 'Valor recuperável = maior entre valor em uso (75k) e valor justo líquido (VJL). Para não haver perda, VJL deve estar entre 75k e 80k (valor contábil), pois o maior valor prevalece.',
            29 => 'NBC TG 47: receita de primeira linha DRE = receitas de atividades ordinárias. Marcação de assentos (150k) + Passagens (900k) = 1.050k. Equivalência patrimonial vai em "Outras receitas".',
            30 => 'PEPS (Primeiro que Entra, Primeiro que Sai): vende primeiro estoque mais antigo. Vendas: 10×80 + 18×(10×80+8×90) + 25×(7×90+18×95) = R$ 4.660 aproximadamente.',
            31 => 'NBC TG 26: resultado abrangente = resultado do período + outros resultados abrangentes. Recompra de ações NÃO afeta resultado. Despesas por natureza (matéria-prima, pessoal) ≠ função. Não há itens extraordinários.',
            32 => 'NBC TG 47: reconhecimento ao longo do tempo quando cliente controla ativo à medida que é construído. Construção no terreno do cliente com pagamentos por andamento = transferência contínua de controle.',
            33 => 'NBC TG 06: arrendamento de baixo valor permite isenção de reconhecimento. Empresa reconhece despesa linearmente ao longo do prazo, sem ativo de direito de uso ou passivo.',
            34 => 'NBC TG 31: ativos mantidos para venda mensuram-se pelo MENOR entre valor contábil e valor justo líquido. Equipamento 1: menor(500k, 750k)=500k. Equipamento 2: menor(1.500k, 1.250k)=1.250k.',
            35 => 'Gastos = sacrifício financeiro (compra). Custos = gastos na produção (matéria-prima). Despesas = gastos não relacionados à produção (vendas). Perdas = gastos anormais (já incluídos no custo é FALSO).',
            36 => 'Superavaliar EI → aumenta valor disponível para venda → aumenta CMV = EI(↑) + Compras - EF → CMV superavaliado → lucro subavaliado.',
            37 => 'Absorção: inclui custos fixos no produto. Variável: custos fixos vão direto p/ resultado. Com 12k produzidas e 9k vendidas, absorção difere custos fixos proporcionais ao estoque. Cálculos: Absorção=45.470, Variável=45.500 (aprox 11.750).',
            38 => 'Custeio ABC rastreia custos por atividade. Distribui R$ 200k: mudanças projeto (140k) e energia (60k) conforme direcionadores. Custos unitários = custos totais / unidades produzidas.',
            39 => 'Capital Próprio = Ativo - Passivo = (50+30+120) - (40+100) = 60k. Proporção = 60k / 200k = 30%. ERRO: resposta C (60%) sugere PL=120k.',
            40 => 'Programação linear: maximizar margem de contribuição sujeito a restrições. Rodinhas limitadas (500). MC: 2 rodinhas=120, 4 rodinhas=230. Modelo ótimo: 50 de 2 rodinhas (100 rodinhas) + 85 de 4 (340 rodinhas) = 440≤500.',
            41 => 'Variação de Taxa = (Preço Real - Preço Padrão) × Horas Reais = (143-150)×1.550 = -10.850 favorável. Variação Eficiência = (Horas Reais - Horas Padrão) × Preço Padrão = (1.550-1.500)×150 = 7.500 desfavorável.',
            42 => 'Custo inicial do ativo: valor de aquisição (50k) + transporte (5k) + preparação local (10k) = 65k. Treinamento é despesa do período (não ativo).',
            43 => 'Frutas/verduras semanais = consumo imediato = operacional (4k). Não perecíveis estocados = investimento? NÃO. Na contabilidade pública, estoque de consumo é operacional. Ambos operacionais = 24k.',
            44 => 'NBC TSP: transação sem contraprestação (doação) reconhece ativo pelo VALOR JUSTO na data de aquisição. Mesmo sem pagamento, ativo tem valor econômico e deve ser reconhecido.',
            45 => 'Receita Líquida = Quantidade × Preço × (1 - Desconto) = 4.000 × 120 × 0,95 = R$ 456.000. Desconto comercial reduz a receita bruta.',
            46 => 'Controladoria + Compliance = gestão + conformidade. Integração: mitigação de riscos (compliance), metas (controladoria), controles internos (ambos). Resposta mais abrangente: apoio à gestão com foco em desempenho E conformidade.',
            47 => 'NBC TA 500: recálculo é procedimento que verifica cálculos matemáticos (depreciação linear é cálculo). Confirmação externa = terceiros. Inspeção = documentos/ativos físicos. Indagação = perguntas.',
            48 => 'NBC TA 300: envolvimento de sócios/membros-chave no planejamento INCORPORA experiência/pontos de vista, OTIMIZANDO eficácia e eficiência. Não se trata de admiração, relacionamento ou controle.',
            49 => 'NBC TP 01: Perícia é competência de contador (III FALSO - não basta notório conhecimento). Laudo/parecer TÊM limite do objeto (II FALSO). Corretas: I (definição) e IV (planejamento).',
            50 => 'NBC TP 01: Parecer Pericial deve ser emitido APENAS quando houver divergência (parcial ou total) com o Laudo. Se houver concordância total, não há necessidade de parecer.',
        ];
    }
}
