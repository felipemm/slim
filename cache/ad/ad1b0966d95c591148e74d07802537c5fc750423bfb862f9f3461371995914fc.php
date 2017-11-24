<?php

/* layout.twig.html */
class __TwigTemplate_4dc844dc705b4c149ca4663a3c8d4a3e57cdd197d0dd13f292f2675906334218 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <title>Slim Framework + Twig Template + Illuminate Database/Validation</title>
  <link rel=\"stylesheet\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, ($context["public"] ?? null), "html", null, true);
        echo "/css/main.css\">
</head>
<body>
  <div class=\"container\">
    <header class=\"header\">
      <h1><a href=\"";
        // line 11
        echo twig_escape_filter($this->env, ($context["baseUrl"] ?? null), "html", null, true);
        echo "\">Slim Framework + Twig Template + Illuminate Database/Validation</a></h1>
    </header>
    ";
        // line 13
        if (twig_get_attribute($this->env, $this->getSourceContext(), ($context["flash"] ?? null), "message", array(), "array")) {
            // line 14
            echo "      <div class=\"alert\">
        <p>";
            // line 15
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["flash"] ?? null), "message", array(), "array"), "html", null, true);
            echo "</p>
      </div>
    ";
        }
        // line 18
        echo "    ";
        $this->displayBlock('content', $context, $blocks);
        // line 19
        echo "    <footer class=\"footer\">
      <a href=\"http://slimframework.com/\">Slim Framework</a> +
      <a href=\"http://twig.sensiolabs.org\">Twig Template</a> +
      <a href=\"https://github.com/illuminate/database\">Illuminate Database</a> +
      <a href=\"https://github.com/illuminate/validation\">Illuminate Validation</a> ;)
    </footer>
  </div>
  <script src=\"";
        // line 26
        echo twig_escape_filter($this->env, ($context["public"] ?? null), "html", null, true);
        echo "/js/app.js\"></script>
</body>
</html>";
    }

    // line 18
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.twig.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 18,  63 => 26,  54 => 19,  51 => 18,  45 => 15,  42 => 14,  40 => 13,  35 => 11,  27 => 6,  20 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.twig.html", "/var/www/html/slim/src/Viewer/layout.twig.html");
    }
}
