<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <section>

        <?php
        session_start();


        if (isset($_POST['limpar_historico'])) {

            $_SESSION['historico'] = array();
        }

        $num1 = isset($_POST["num1"]) ? $_POST["num1"] : '';
        $num2 = isset($_POST["num2"]) ? $_POST["num2"] : '';
        $operador = isset($_POST["operador"]) ? $_POST["operador"] : '';
        $calcular = isset($_POST["calcular"]) ? $_POST["calcular"] : "";
        $resultado = '';
        $historico = isset($_SESSION['historico']) ? $_SESSION['historico'] : array();
        $memoria = isset($_SESSION['memoria']) ? $_SESSION['memoria'] : array();
        $resultado2 = '';

        function fatoracao($num1)
        {
            $fatores = array();

            for ($i = 2; $i <= $num1; $i++) {
                while ($num1 % $i == 0) {
                    $fatores[] = $i;
                    $num1 /= $i;
                }
            }

            return $fatores;
        }

        if (isset($_POST['salvar_memoria'])) {

            $_SESSION['memoria'] = array(
                'num1' => $num1,
                'num2' => $num2,
                'operador' => $operador
            );
        }

        if (isset($_POST['recuperar_memoria'])) {

            $num1 = isset($memoria['num1']) ? $memoria['num1'] : '';
            $num2 = isset($memoria['num2']) ? $memoria['num2'] : '';
            $operador = isset($memoria['operador']) ? $memoria['operador'] : $operador;
        }

        $num1 = floatval($num1);
        $num2 = floatval($num2);


        if ($calcular == "sim") {

            switch ($operador) {
                case '+':
                    $resultado = $num1 + $num2;
                    break;

                case '-':
                    $resultado = $num1 - $num2;
                    break;

                case '/':
                    if ($num2 == 0) {
                        $resultado = "Erro: divisão por zero.";
                    } else {
                        $resultado = $num1 / $num2;
                    }
                    break;

                case '*':
                    $resultado = $num1 * $num2;
                    break;

                case '^':
                    $resultado = pow($num1, $num2);
                    break;

                case '!':
                    $resultado2 = fatoracao($num1);
                    $resultado = implode(" * ", $resultado2);
                    break;

                default:
                    $resultado = "Operador inválido";
                    break;
            }

            $historico[] = array(
                'num1' => $num1,
                'num2' => $num2,
                'operador' => $operador,
                'resultado' => $resultado
            );

            $_SESSION['historico'] = $historico;

            $calcular = "";

        }
        ?> 

        <div class="divisaoTotal">
            <button type="button" class="btn btn-secondary" id="titulo1" disabled>Calculadora</button>
            <div class="divisao1">
                <form action="" method="post">
                    <input type="number" name="num1" class="num1" value="<?= $num1 ?>">

                    <select name="operador" class="operador">
                        <option value="+" <?= $operador == '+' ? 'selected' : '' ?>>+</option>
                        <option value="-" <?= $operador == '-' ? 'selected' : '' ?>>-</option>
                        <option value="/" <?= $operador == '/' ? 'selected' : '' ?>>/</option>
                        <option value="*" <?= $operador == '*' ? 'selected' : '' ?>>*</option>
                        <option value="^" <?= $operador == '^' ? 'selected' : '' ?>>^</option>
                        <option value="!" <?= $operador == '!' ? 'selected' : '' ?>>!</option>
                    </select>

                    <input type="text" name="num2" class="num2" value="<?= $num2 ?>">

                    <br>

                    <label for="resultado"></label>
                    <input type="number" name="resultado" class="resultado" placeholder="<?= $resultado ?>">

                    <br>

                    <button type="submit" class="btn btn-primary" name="calcular" value="sim">calcular</button>
                    <button type="submit" class="btn btn-danger" name="limpar_historico">Limpar Historico</button>
                    <button type="submit" class="btn btn-info" name="salvar_memoria">M (salvar Memoria)</button>
                    <button type="submit" class="btn btn-info" name="recuperar_memoria">M(Recuperar)</button>
    
                </form>
            </div>

            <div class="divisao2">
                <ul>
                    <?php foreach ($historico as $his) : ?>
                        <li><?= $his['num1'] . $his['operador'] . $his['num2'] . '=' . $his['resultado'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</body>

</html>