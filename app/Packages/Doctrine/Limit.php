<?php

namespace App\Packages\Doctrine;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Subselect;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Limit extends FunctionNode
{

    private $subselect;
    private $limit;

    public function getSql(SqlWalker $sqlWalker)
    {
        return '(' . $this->subselect->dispatch($sqlWalker) . 'LIMIT ' . $this->limit . ')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        dump($this->subselect = $parser->SelectStatement());
        $parser->match(Lexer::T_COMMA);
        dump($this->limit = $parser->InputParameter());
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}