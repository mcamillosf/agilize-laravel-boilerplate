<?php

namespace App\Packages\Prova\Seed;


use App\Packages\Prova\Domain\Model\Materia;
use App\Packages\Prova\Domain\Model\Pergunta;
use Illuminate\Database\Seeder;
use LaravelDoctrine\ORM\Facades\EntityManager;

class PerguntasSeed extends Seeder
{
    public function run():void
    {
       $materiaRepository = EntityManager::getRepository(Materia::class);
       $materiaJavascript = $materiaRepository->findOneBy(['materia' => 'Javascript']);
       $materiaPHP = $materiaRepository->findOneBy(['materia' => 'PHP']);


        $perguntasSeeder = [
           ['pergunta' => "Como você escreve um 'Hello World' dentro de um alert box?", 'materia' => $materiaJavascript],
           ['pergunta' => "Como escrever uma instrução IF em JavaScript?", 'materia' => $materiaJavascript],
           ['pergunta' => "Dentro de qual elemento HTML colocamos o JavaScript?", 'materia' => $materiaJavascript],
           ['pergunta' => "Como um loop FOR é iniciado?", 'materia' => $materiaJavascript],
           ['pergunta' => "Como escrever uma instrução IF para executar algum código se 'i' NÃO for igual a 5?", 'materia' => $materiaJavascript],
           ['pergunta' => "Como você encontra o número com o maior valor de x e y?", 'materia' => $materiaJavascript],
           ['pergunta' => "Como você arredonda o número 7.25, para o inteiro mais próximo?", 'materia' => $materiaJavascript],
           ['pergunta' => "Os scripts de servidor PHP são cercados por delimitadores, quais?", 'materia' => $materiaPHP],
           ['pergunta' => "Qual é a maneira correta de terminar uma instrução PHP?", 'materia' => $materiaPHP],
           ['pergunta' => "Qual é a maneira correta de incluir o arquivo 'time.inc'?", 'materia' => $materiaPHP],
           ['pergunta' => "Qual é a maneira correta de abrir o arquivo 'time.txt' como legível?", 'materia' => $materiaPHP],
           ['pergunta' => "Qual variável superglobal contém informações sobre cabeçalhos, caminhos e locais de script?", 'materia' => $materiaPHP],
           ['pergunta' => 'Qual é a maneira correta de adicionar 1 à variável $count?', 'materia' => $materiaPHP],
           ['pergunta' => "Qual é a maneira correta de adicionar um comentário em PHP?", 'materia' => $materiaPHP],
           ['pergunta' => "Qual operador é usado para verificar se dois valores são iguais e do mesmo tipo de dados?", 'materia' => $materiaPHP],
       ];

       foreach ($perguntasSeeder as $perguntaSeed) {
           EntityManager::persist(
               new Pergunta($perguntaSeed['pergunta'], $perguntaSeed['materia']
               )
           );
           EntityManager::flush();
       }
    }
}