<?php

/* books.twig.html */
class __TwigTemplate_f7292df67062e1430b95c9b87071dd973d5e782c62b7592917140ee1b3e0d743 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.twig.html", "books.twig.html", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "<section class=\"section\">
  <ul class=\"list\">
    ";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["books"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["book"]) {
            // line 6
            echo "    <li>
        <strong>";
            // line 7
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["book"], "id", array()), "html", null, true);
            echo " - ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["book"], "book_name", array()), "html", null, true);
            echo " - ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["book"], "status", array()), "html", null, true);
            echo "</strong>
    </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['book'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "  </ul>
</section>
";
    }

    public function getTemplateName()
    {
        return "books.twig.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 10,  42 => 7,  39 => 6,  35 => 5,  31 => 3,  28 => 2,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "books.twig.html", "/var/www/html/slim/src/Viewer/books.twig.html");
    }
}
