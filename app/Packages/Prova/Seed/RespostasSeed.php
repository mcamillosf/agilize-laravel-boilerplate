<?php

namespace App\Packages\Prova\Seed;


use App\Packages\Prova\Domain\Model\Pergunta;
use App\Packages\Prova\Domain\Model\Resposta;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class RespostasSeed extends Seeder
{
    public function run(): void
    {
        $perguntaRepository = EntityManager::getRepository(Pergunta::class);
        $pergunta_javascript_1 = $perguntaRepository->findOneBy(['pergunta' => "Como você escreve um 'Hello World' dentro de um alert box?"]);
        $pergunta_javascript_2 = $perguntaRepository->findOneBy(['pergunta' => "Como escrever uma instrução IF em JavaScript?"]);
        $pergunta_javascript_3 = $perguntaRepository->findOneBy(['pergunta' => "Dentro de qual elemento HTML colocamos o JavaScript?"]);
        $pergunta_javascript_4 = $perguntaRepository->findOneBy(['pergunta' => "Como um loop FOR é iniciado?"]);
        $pergunta_javascript_5 = $perguntaRepository->findOneBy(['pergunta' => "Como escrever uma instrução IF para executar algum código se 'i' NÃO for igual a 5?"]);
        $pergunta_javascript_6 = $perguntaRepository->findOneBy(['pergunta' => "Como você encontra o número com o maior valor de x e y?"]);
        $pergunta_javascript_7 = $perguntaRepository->findOneBy(['pergunta' => "Como você arredonda o número 7.25, para o inteiro mais próximo?"]);
        $pergunta_php_1 = $perguntaRepository->findOneBy(['pergunta' => "Os scripts de servidor PHP são cercados por delimitadores, quais?"]);
        $pergunta_php_2 = $perguntaRepository->findOneBy(['pergunta' => "Qual é a maneira correta de terminar uma instrução PHP?"]);
        $pergunta_php_3 = $perguntaRepository->findOneBy(['pergunta' => "Qual é a maneira correta de incluir o arquivo 'time.inc'?"]);
        $pergunta_php_4 = $perguntaRepository->findOneBy(['pergunta' => "Qual é a maneira correta de abrir o arquivo 'time.txt' como legível?"]);
        $pergunta_php_5 = $perguntaRepository->findOneBy(['pergunta' => "Qual variável superglobal contém informações sobre cabeçalhos, caminhos e locais de script?"]);
        $pergunta_php_6 = $perguntaRepository->findOneBy(['pergunta' => 'Qual é a maneira correta de adicionar 1 à variável $count?']);
        $pergunta_php_7 = $perguntaRepository->findOneBy(['pergunta' => "Qual é a maneira correta de adicionar um comentário em PHP?"]);
        $pergunta_php_8 = $perguntaRepository->findOneBy(['pergunta' => "Qual operador é usado para verificar se dois valores são iguais e do mesmo tipo de dados?"]);

        $respostasSeeder = [
            ['resposta' => "alert('Hello World')", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_1],
            ['resposta' => "msgBox('Hello World')", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_1],
            ['resposta' => "alertBox('Hello World')", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_1],
            ['resposta' => "msg('Hello World')", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_1],
            ['resposta' => "if i = 5 then", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_2],
            ['resposta' => "if i == 5 then", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_2],
            ['resposta' => "if (i == 5)", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_2],
            ['resposta' => "if i = 5", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_2],
            ['resposta' => "<scripting>", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_3],
            ['resposta' => "<script>", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_3],
            ['resposta' => "<javascript>", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_3],
            ['resposta' => "<js>", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_3],
            ['resposta' => "for i = 1 to 5", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_4],
            ['resposta' => "for (i = 0; i <= 5; i++)", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_4],
            ['resposta' => "for (i <= 5; i++)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_4],
            ['resposta' => "for (i = 0; i <= 5)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_4],
            ['resposta' => "if i <> 5", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_5],
            ['resposta' => "if (i <> 5)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_5],
            ['resposta' => "if i =! 5 then", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_5],
            ['resposta' => "if (i != 5)", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_5],
            ['resposta' => "top(x, y)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_6],
            ['resposta' => "Math.ceil(x, y)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_6],
            ['resposta' => "Math.max(x, y)", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_6],
            ['resposta' => "ceil(x, y)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_6],
            ['resposta' => "Math.round(7.25)", 'resposta_correta' => true, 'pergunta' => $pergunta_javascript_7],
            ['resposta' => "Math.rnd(7.25)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_7],
            ['resposta' => "round(7.25)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_7],
            ['resposta' => "rnd(7.25)", 'resposta_correta' => false, 'pergunta' => $pergunta_javascript_7],
            ['resposta' => "<?php...?>", 'resposta_correta' => true, 'pergunta' => $pergunta_php_1],
            ['resposta' => "<script>...</script>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_1],
            ['resposta' => "<&>...</&>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_1],
            ['resposta' => "<?php>...</?>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_1],
            ['resposta' => ";", 'resposta_correta' => true, 'pergunta' => $pergunta_php_2],
            ['resposta' => ".", 'resposta_correta' => false, 'pergunta' => $pergunta_php_2],
            ['resposta' => "Nova linha", 'resposta_correta' => false, 'pergunta' => $pergunta_php_2],
            ['resposta' => "</php>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_2],
            ['resposta' => "<?php include file='time.inc'; ?>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_3],
            ['resposta' => "<?php include:'time.inc'; ?>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_3],
            ['resposta' => "<!-- include file='time.inc' -->", 'resposta_correta' => false, 'pergunta' => $pergunta_php_3],
            ['resposta' => "<?php include 'time.inc'; ?>", 'resposta_correta' => true, 'pergunta' => $pergunta_php_3],
            ['resposta' => "fopen('hora.txt','r');", 'resposta_correta' => true, 'pergunta' => $pergunta_php_4],
            ['resposta' => "open('hora.txt');", 'resposta_correta' => false, 'pergunta' => $pergunta_php_4],
            ['resposta' => "open('hora.txt','ler');", 'resposta_correta' => false, 'pergunta' => $pergunta_php_4],
            ['resposta' => "fopen('hora.txt','r+');", 'resposta_correta' => false, 'pergunta' => $pergunta_php_4],
            ['resposta' => '$_SERVER', 'resposta_correta' => true, 'pergunta' => $pergunta_php_5],
            ['resposta' => '$GLOBALS', 'resposta_correta' => false, 'pergunta' => $pergunta_php_5],
            ['resposta' => '$_SESSION', 'resposta_correta' => false, 'pergunta' => $pergunta_php_5],
            ['resposta' => '$_GET', 'resposta_correta' => false, 'pergunta' => $pergunta_php_5],
            ['resposta' => "contagem++;", 'resposta_correta' => false, 'pergunta' => $pergunta_php_6],
            ['resposta' => '$conta =+1', 'resposta_correta' => false, 'pergunta' => $pergunta_php_6],
            ['resposta' => "++contar", 'resposta_correta' => false, 'pergunta' => $pergunta_php_6],
            ['resposta' => '$conta++;', 'resposta_correta' => true, 'pergunta' => $pergunta_php_6],
            ['resposta' => "<!--...-->", 'resposta_correta' => false, 'pergunta' => $pergunta_php_7],
            ['resposta' => "<comment>...</comment>", 'resposta_correta' => false, 'pergunta' => $pergunta_php_7],
            ['resposta' => "/*...*/", 'resposta_correta' => true, 'pergunta' => $pergunta_php_7],
            ['resposta' => "*\...\*", 'resposta_correta' => false, 'pergunta' => $pergunta_php_7],
            ['resposta' => "!=", 'resposta_correta' => false, 'pergunta' => $pergunta_php_8],
            ['resposta' => "===", 'resposta_correta' => true, 'pergunta' => $pergunta_php_8],
            ['resposta' => "==", 'resposta_correta' => false, 'pergunta' => $pergunta_php_8],
            ['resposta' => "=", 'resposta_correta' => false, 'pergunta' => $pergunta_php_8],

        ];

        foreach ($respostasSeeder as $respostaSeed) {
            EntityManager::persist(
                new Resposta(
                    $respostaSeed['resposta'], $respostaSeed['resposta_correta'], $respostaSeed['pergunta']
                )
            );
            EntityManager::flush();
        }
    }
}