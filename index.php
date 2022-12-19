<?php
include_once("./header.php");
?>


<form class="form_user" id="form-create-user">
    <h2>Criar conta</h2>
    <div class="">
        <label for="username">Username</label>
        <input type="text" id="username" placeholder="Enter your name">
        <small></small>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" id="email" placeholder="Enter your email">
        <small></small>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" id="password" placeholder="Enter your password">
        <small></small>
    </div>

    <div>
        <button id="btn-cadastro">Cadastrar</button>
    </div>
    <p>Ja ten conta? faça <button id="btn-go-login">Login</button></p>
</form>

<form class="form_user" id="form-login-user">
    <h2>Login</h2>
    <div>
        <label for="email">Email</label>
        <input type="text" id="emailLogin" placeholder="Enter your email">
        <span></span>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" id="passwordLogin" placeholder="Enter your password">
        <span></span>
    </div>

    <div>
        <button id="btn-login">Login</button>
    </div>
    <p>Ainda não tem conta? faça <button id="btn-go-cadastro">cadastro</button></p>
</form>








<?php include_once("./footer.php")  ?>