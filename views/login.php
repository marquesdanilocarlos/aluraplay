<?php require_once __DIR__ . "/header.php"; ?>
    <main class="container">

        <form class="container__formulario" method="post">
            <h2 class="formulario__titulo">Efetue login</h2>
                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="usuario">Usuário</label>
                    <input type="email" name="email" class="campo__escrita" required
                        placeholder="Digite seu usuário" id='usuario' />
                </div>


                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="senha">Senha</label>
                    <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha"
                        id='senha' />
                </div>

                <input class="formulario__botao" type="submit" value="Entrar" />
        </form>

    </main>
<?php require_once __DIR__ . "/footer.php"; ?>