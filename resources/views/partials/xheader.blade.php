<div id="xheader">
    <!--Usefull link : https://www.fundaofwebit.com/laravel-8/how-to-show-success-message-in-laravel-8-->
    <!-- Include jQuery Toast CSS and JS files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @if (session()->has('message'))
        {{-- <div class="alert alert-success" id="success">
            {{ session()->get('message') }}
        </div>
        <script>
            window.addEventListener("DOMContentLoaded", (event) => {

                ///////////////////////////
                //Usefull link : https://www.geeksforgeeks.org/how-to-hide-div-element-after-few-seconds-in-jquery/
                //const urlParams = new URLSearchParams(queryString);


                alertc = document.getElementById("success");

                // Add the 'hidden' class after a delay
                let delayInSeconds = 3; // Set your desired delay time in seconds
                setTimeout(() => {
                    alertc.classList.add("hiddenalert");
                }, delayInSeconds * 1000);
            });
            
        </script> --}}
        <script>
            $(()=>{
                Toastify({
                text: '{{session()->get('message')}}',
                duration: 5000,
                position: "center",
                gravity: "bottom",
                close: true,
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#008000",
                    borderRadius: "15px",
                    fontSize: '20px',
                },
            }).showToast();

            })
        </script>
    @endif
    <header>
        <div class="header-container">
            <div class="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="app-name">
                <a href="/" style="text-decoration: none; color:white;">
                    <h1>@yield('appname')</h1>
                </a>
            </div>
            <nav class="nav">
                <ul class="ul-menu">
                    <li><a href="/publication">Trouver un véhicule</a></li>
                    @auth
                        <li><a href="/users/{{ Auth::id() }}">Mes annonces</a></li>
                        <li><a href="/publication/create">Publier une annonce</a></li>
                        @if(Auth()->user()->isAdmin())
                            <li><a href="/admin">Centre des demandes</a></li>
                        @endif
                        {{-- <li><a href="/publications/saved">Annonces suivies</a></li> --}}
                        <li id="btn-deco-mobile">
                            <form action="/logout" method="GET" class="d-flex align-items-top">
                                @csrf
                                <button type="submit" class="d-flex align-items-center btn-disconnect" id="btn-deco" style="gap: 20px;">
                                    <i class="fas fa-sign-out-alt"></i><div>Se deconnecter</div>

                                </button>
                            </form>
                        </li>
                        <li>

                        </li>
                    @endauth
                </ul>
            </nav>

            <div style="display: grid; grid-template-columns: auto auto;gap:20px;">
                @auth
                    {{-- <form action="/logout" method="GET">
                        <button class="login-button redlogout-button">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form> --}}
                   
                    <a href="/users/{{ Auth::id() }}">
                        <div class="imgProfile" style="background-image: url('{{ Auth::user()->getImage() }}')"></div>
                        
                    </a>
                    <form action="/logout" method="GET" class="d-flex align-items-top">
                        @csrf
                        <button type="submit" class="d-flex align-items-center btn-disconnect" id="btn-deco-desktop"
                            style="gap: 15px;">
                            <i class="fas fa-sign-out-alt"></i>
                            <div>Se deconnecter</div>

                        </button>
                    </form>
                @else
                    <a href="/login">
                        <button class="login-button">
                            <i class="fas fa-sign-in-alt"></i>
                        </button>
                    </a>
                @endauth
            </div>

        </div>
    </header>
</div>


<style>
    /* Ajoutez du CSS pour rendre le bouton carré sur les appareils mobiles */
    @media (orientation: portrait) {
        .login-button {
            width: .1rem;
            /* Définissez la largeur et la hauteur du bouton carré */
            height: 3rem;
            font-size: 1rem;
            /* Réglez la taille de l'icône */
            display: flex;
            align-items: center;
            justify-content: center;
            /* Centre l'icône horizontalement */
        }
    }

    /* Ajoutez le style pour l'image de profil ici */
    .imgProfile {
        width: 3rem;
        height: 3rem;
        margin-left: 1rem;
        border-radius: 100%;
        outline: 3px solid var(--blueForms);
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const menuIcon = document.querySelector(".menu-icon");
        const navLinks = document.querySelector(".nav ul");

        menuIcon.addEventListener("click", function() {
            navLinks.classList.toggle("active");
        });


    });
</script>
