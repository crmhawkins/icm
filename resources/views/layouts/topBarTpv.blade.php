<nav id="topbar" class="navbar">
    <header class="top-burguer">
        <a href="#" class="burger-btn d-block ">
            <i class="bi bi-list"></i>
        </a>
    </header>
    <ul class="topbar-menu d-flex align-items-center gap-3">

        <li class="d-none d-sm-inline-block">
            <div class="nav-link" >
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket "></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
    <style>
        .li-flex {
            display: flex;
            justify-content: space-between;
        }

        .li-mensaje {
            flex: 0 0 80%; /* Asigna el 80% del espacio disponible */
        }

        .li-boton {
            flex: 0 0 20%; /* Asigna el 20% del espacio restante */
            display: flex;
            justify-content: space-around; /* Distribuye uniformemente los botones dentro del contenedor */
        }
        .tituloalertas {
            font-size: 24px;
            color: #3078d6; /* Cambia el color del título */
            font-weight: bold; /* Hace el título en negrita */
        }

        .popupaletas {
            background-color: #ffffff; /* Cambia el color de fondo del popup */
            width: 900px; /* Aumenta el ancho del popup */
            max-height: 700px;     /* Altura máxima de 700px */
            overflow-y: auto;      /* Habilita el scroll si se excede la altura */
            border-radius: 10px;   /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra suave */
            background-color: white; /* Fondo blanco */
        }

        .contenidoalerta ul li {
        margin-bottom: 10px;
        list-style-type: none;
        padding: 5px;
        border-bottom: 1px solid #ffffff;
        }

        .btn-pop {
            background-color: #4CAF50; /* Color de fondo */
            color: white;             /* Color del texto */
            padding: 10px 20px;       /* Relleno: arriba-abajo, izquierda-derecha */
            border: none;             /* Sin borde */
            border-radius: 5px;       /* Bordes redondeados */
            cursor: pointer;          /* Cambiar el cursor a una mano */
            font-size: 16px;          /* Tamaño de fuente */
        }

        .btn-pop:hover {
            background-color: #45a049; /* Color de fondo al pasar el mouse */
        }

        .li-flex {
            display: flex;
            justify-content: space-between; /* Distribuye el espacio entre los elementos */
            align-items: center;            /* Alinea los elementos verticalmente */
            padding: 5px;                   /* Agrega algo de relleno */
        }

    </style>
</nav>

