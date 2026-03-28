<?php

session_start();


if (!isset($_SESSION['alunos'])) {
    $_SESSION['alunos'] = [];
}


if (isset($_POST['action']) && $_POST['action'] == 'save') {
    $novoAluno = [
        'id' => uniqid(),
        'nome' => htmlspecialchars($_POST['nome']),
        'matricula' => htmlspecialchars($_POST['matricula']),
        'curso' => htmlspecialchars($_POST['curso'])
    ];
    $_SESSION['alunos'][] = $novoAluno;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_GET['delete'])) {
    $idParaRemover = $_GET['delete'];
    $_SESSION['alunos'] = array_filter($_SESSION['alunos'], function($aluno) use ($idParaRemover) {
        return $aluno['id'] !== $idParaRemover;
    });
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --rosa-pastel: #FFD1DC;
            --rosa-vibrante: #FF85A2;
            --roxo-suave: #E0BBE4;
            --branco-nuvem: #FFFFFF;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, var(--rosa-pastel), var(--roxo-suave));
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
            color: #555;
        }

       
        .sparkle {
            position: fixed;
            background: white;
            border-radius: 50%;
            opacity: 0.5;
            animation: move-sparkle 5s linear infinite;
            z-index: -1;
        }

        @keyframes move-sparkle {
            0% { transform: translateY(0) scale(1); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(0.5); opacity: 0; }
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(255, 133, 162, 0.3);
            width: 450px;
            backdrop-filter: blur(5px);
            border: 3px solid var(--branco-nuvem);
        }

        h2 {
            text-align: center;
            color: var(--rosa-vibrante);
            margin-bottom: 1.5rem;
        }

        .input-group { margin-bottom: 15px; }

        input {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--rosa-pastel);
            border-radius: 15px;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus { border-color: var(--rosa-vibrante); }

      
        .btn-heart {
            background: var(--rosa-vibrante);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-heart:hover {
            transform: scale(1.05);
            background: #ff5e84;
        }

        .btn-heart::after {
            content: ' ❤';
        }

        
        .student-list {
            margin-top: 2rem;
            border-top: 2px dashed var(--rosa-pastel);
            padding-top: 1rem;
        }

        .student-card {
            background: white;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 5px solid var(--roxo-suave);
        }

        .btn-delete {
            background: none;
            border: none;
            color: #ffb7c5;
            cursor: pointer;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<div class="sparkle" style="left: 10%; width: 10px; height: 10px; animation-delay: 0s;"></div>
<div class="sparkle" style="left: 30%; width: 5px; height: 5px; animation-delay: 2s;"></div>
<div class="sparkle" style="left: 70%; width: 8px; height: 8px; animation-delay: 1s;"></div>

<div class="container">
    <h2>Cadastre seu aluno aqui!</h2>
    
    <form method="POST">
        <input type="hidden" name="action" value="save">
        <div class="input-group">
            <input type="text" name="nome" placeholder="Nome do Aluno..." required>
        </div>
        <div class="input-group">
            <input type="text" name="matricula" placeholder="Matrícula..." required>
        </div>
        <div class="input-group">
            <input type="text" name="curso" placeholder="Curso..." required>
        </div>
        <button type="submit" class="btn-heart">Cadastrar Aluno</button>
    </form>

    <div class="student-list">
        <h3>Alunos cadastrados:</h3>
        <?php if (empty($_SESSION['alunos'])): ?>
            <p style="text-align:center; font-style: italic;">Nenhum aluno cadastrado ainda... </p>
        <?php else: ?>
            <?php foreach ($_SESSION['alunos'] as $aluno): ?>
                <div class="student-card">
                    <div>
                        <strong><?= $aluno['nome'] ?></strong><br>
                        <small><?= $aluno['matricula'] ?> • <?= $aluno['curso'] ?></small>
                    </div>
                    <a href="?delete=<?= $aluno['id'] ?>" class="btn-delete" onclick="return confirm('Quer mesmo remover este aluno?')">✖</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>