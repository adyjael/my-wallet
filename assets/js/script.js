$(function () {

    var username = document.getElementById("username");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var usernameValue = $("#username").val()
    var emailValue = $("#email").val()
    var passwordValue = $("#password").val()



    $("#btn-go-login").on("click", function (e) {
        e.preventDefault();
        $("#form-create-user").hide();
        $("#form-login-user").show();
    })
    $("#btn-go-cadastro").on("click", function (e) {
        e.preventDefault();
        $("#form-create-user").show();
        $("#form-login-user").hide();
    })



    // BTN CREATE USER

    $("#btn-cadastro").on("click", function (e) {
        e.preventDefault();
        var usernameValue = $("#username").val()
        var emailValue = $("#email").val()
        var passwordValue = $("#password").val()


        if (usernameValue.trim() == "") {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Usename invalido!',
            })
        } else if (emailValue.trim() == "") {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Preancha o email!',
            })
        } else if (passwordValue.trim() == "") {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Preencha a password!',
            })
        } else if (!validaetEmail(emailValue)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Email invalido!',
            })
        } else if (passwordValue.length < 8) {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Password ten que ter mais de 8 caracteres',
            })
        }
        else {

            $.ajax({
                url: "account.php",
                type: "POST",
                dateType: "JSON",
                data: {
                    "type": "cadastro",
                    username: usernameValue,
                    email: emailValue,
                    password: passwordValue,
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.msg,
                        })
                    } else {
                        window.location = "dashboard.php";
                    }


                },
                error: function (error) {
                    console.log(error);
                }
            })


        }

    })
    $("#btn-login").on("click", function (e) {
        e.preventDefault();
        var emailValue = $("#emailLogin").val()
        var passwordValue = $("#passwordLogin").val()

        if (emailValue.trim() == "") {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Preancha o email!',
            })
        } else if (passwordValue.trim() == "") {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Preencha a password!',
            })
        } else if (!validaetEmail(emailValue)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Email invalido!',
            })
        } else {

            $.ajax({
                url: "account.php",
                type: "POST",
                dateType: "JSON",
                data: {
                    "type": "login",
                    username: usernameValue,
                    email: emailValue,
                    password: passwordValue,
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: response.msg,
                        })
                    } else {
                        window.location = "dashboard.php";
                    }


                },
                error: function (error) {
                    console.log(error);
                }
            })


        }

    })



    function validaetEmail(email) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            email
        );
    }





    // DEPOSITAR

    $("#btn-deposit").on("click", function (e) {
        e.preventDefault();

        var valor = $("#valor-depositar").val();
        var id_user = $("#id_user").val()
        if (valor.trim() == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Preencha o campoo",
            })
            return;
        }
        if (isNaN(valor)) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Valor digitado está incorrecto! Verifique se não contem letras ou Subistitua as virgulas(,) por ponto(.)",
            })

        } else {


            $.ajax({
                url: "Bank.php",
                dateType: "JSON",
                type: "POST",
                data: {
                    type: "deposit",
                    id_user: id_user,
                    valor: valor,
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: response.msg,
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Depositou $" + valor,
                        })
                        setTimeout(function () {
                            document.location.reload(true);
                        }, 1700);
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            })



        }





    })



    // RETIRAR

    $("#btn-retirar").on("click", function (e) {
        e.preventDefault();

        var valorRetirar = $("#valor-retirar").val();
        var id_user = $("#id_user-retirar").val()
        var motivo = $("#motivo-retirar").val()
        if (valorRetirar.trim() == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Preencha o campoo",
            })
            return;
        }
        if (isNaN(valorRetirar)) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Valor digitado está incorrecto! Verifique se não contem letras ou Subistitua as virgulas(,) por ponto(.)",
            })

        } else {



            $.ajax({
                url: "Bank.php",
                dateType: "JSON",
                type: "POST",
                data: {
                    type: "retirar",
                    id_user: id_user,
                    valor: valorRetirar,
                    motivo: motivo,
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: response.msg,
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Retirou $" + valorRetirar,
                        })
                        setTimeout(function () {
                            document.location.reload(true);
                        }, 1700);
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            })



        }





    })










    // ENVIAR

    $("#btn-enviar").on("click", function (e) {
        e.preventDefault();

        var valorEnviar = $("#valor-enviar").val();
        var userEnviar = $("#id_user-enviar").val()
        var userReceber = $("#user-receber option:selected").val();
        var motivo = $("#motivo-enviar").val()
        if (valorEnviar.trim() == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Preencha o campoo",
            })
            return;
        }
        if (isNaN(valorEnviar)) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Valor digitado está incorrecto! Verifique se não contem letras ou Subistitua as virgulas(,) por ponto(.)",
            })

        } else if (userReceber == 0) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "Selecione o usuario que irá receber",
            })
        } else {



            $.ajax({
                url: "Bank.php",
                dateType: "JSON",
                type: "POST",
                data: {
                    type: "enviar",
                    userEnviar: userEnviar,
                    userReceber: userReceber,
                    valor: valorEnviar,
                    motivo: motivo,
                },
                success: function (response) {
                    response = JSON.parse(response);

                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: response.msg,
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Trasnferio $" + valorEnviar,
                        })
                        setTimeout(function () {
                            document.location.reload(true);
                        }, 1700);
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            })



        }








        // RESETAR


    })
    $("#btn-resetar").on("click", function (e) {
        e.preventDefault();

        var id_user = ($(this).attr("reset"));
        $.ajax({
            url: "Bank.php",
            dateType: "JSON",
            type: "POST",
            data: {
                type: "reset",
                id_user: id_user,
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "Agora vc é um pobre!",
                })
                setTimeout(function () {
                    document.location.reload(true);
                }, 1700);


            },
            error: function (error) {
                console.log(error);
            }
        })



    }



    )

   



    

    
  

















})