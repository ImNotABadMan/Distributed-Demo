<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpParser\Error;
use PhpParser\Node;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;

class DemoController extends Controller
{
    //
    public function index()
    {
        phpinfo();
        echo "<pre>";
        $test = (new Collection([0, 10]))->toArray();
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class extends NodeVisitorAbstract {
            public function enterNode(Node $node) {
                if ($node instanceof Function_) {
                    // Clean out the function body
                    $node->stmts = [];
                }
            }
        });

        $dumper = new NodeDumper();

        $ast = $traverser->traverse($test);
        echo $dumper->dump($ast) . "\n";

        $code = <<<'CODE'
<?php

function test($foo)
{
    var_dump($foo);
}
CODE;

        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($code);
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }

        $dumper = new NodeDumper;
        echo $dumper->dump($ast) . "\n";
    }
}

