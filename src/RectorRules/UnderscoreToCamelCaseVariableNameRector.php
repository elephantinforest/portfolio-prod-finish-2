<?php

declare(strict_types=1);

namespace RectorRules;

use PhpParser\Node;
use PhpParser\Node\Expr\Variable;
use Rector\Core\Php\ReservedKeywordAnalyzer;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class UnderscoreToCamelCaseVariableNameRector extends AbstractRector
{
  private const PARAM_NAME_REGEX = '#(?<paramPrefix>@param\s.*\s+\$)(?<paramName>%s)#ms';

  private ReservedKeywordAnalyzer $reservedKeywordAnalyzer;

  public function __construct(ReservedKeywordAnalyzer $reservedKeywordAnalyzer)
  {
    $this->reservedKeywordAnalyzer = $reservedKeywordAnalyzer;
  }

  public function getRuleDefinition(): RuleDefinition
  {
    return new RuleDefinition('Change under_score names to camelCase', [
      new CodeSample(
        <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($a_b)
    {
        $some_value = $a_b;
    }
}
CODE_SAMPLE,
        <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run($aB)
    {
        $someValue = $aB;
    }
}
CODE_SAMPLE
      ),
    ]);
  }

  public function getNodeTypes(): array
  {
    return [Variable::class];
  }

  public function refactor(Node $node): ?Node
  {
    if (!$node instanceof Variable) {
      return null;
    }

    $nodeName = $this->getName($node);
    if ($nodeName === null || strpos($nodeName, '_') === false) {
      return null;
    }

    if ($this->reservedKeywordAnalyzer->isReserved($nodeName)) {
      return null;
    }

    $replaceUnderscoreToSpace = str_replace('_', ' ', $nodeName);
    $uppercaseFirstChar = ucwords($replaceUnderscoreToSpace);
    $camelCaseName = lcfirst(str_replace(' ', '', $uppercaseFirstChar));

    $node->name = $camelCaseName;

    return $node;
  }
}
