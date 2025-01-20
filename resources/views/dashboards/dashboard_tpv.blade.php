@extends('layouts.appTpv')

@section('titulo', 'Dashboard TPV')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/Tpv.css')}}" />


@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important;" >
    <div class="tpv-container">
        <div class="categories gris">
            <div class="d-flex  flex-wrap g-2">
                @foreach ($categories as $category)
                <div class="col-6 col-md-2">
                    <div class="card category-card border-0 shadow-sm text-center mx-1 mb-1" data-category-id="{{$category->id }}">
                        <div class="card-body  text-center p-0">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="card-img-top rounded">
                            <h6 class="card-title text-primary my-1">{{ $category->name }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Productos -->
        <div class="products gris">
            <div class="d-flex flex-wrap">
                @foreach ($products as $product)
                <div class="col-6 product-card col-md-2" data-category-id="{{ $product->category_id }}">
                    <div class="card border-0 shadow-sm mx-1 mb-1" >
                        <div class="card-body text-center p-0">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top rounded">
                            <h6 class="card-title my-1">{{ $product->name }}</h6>
                            <p class="text-muted mb-0">{{ $product->price }}€</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Cuenta -->
        <div class="cart">
            <div class="cart-items px-2">
            </div>
            <div class="cart-total">Total: 0.00€</div>
        </div>

        <!-- Panel Numérico -->
        <div class="numpad card border-0 shadow-sm">
            <div class="card-body gris d-grid gap-2" style="grid-template-columns: repeat(4, 1fr);">
                <div class="display-cantidad">
                </div>
                <button class="btn btn-light">7</button>
                <button class="btn btn-light">8</button>
                <button class="btn btn-light">9</button>
                <button class="btn btn-light">4</button>
                <button class="btn btn-light">5</button>
                <button class="btn btn-light">6</button>
                <button class="btn btn-light">1</button>
                <button class="btn btn-light">2</button>
                <button class="btn btn-light">3</button>
                <button class="btn btn-light">0</button>
                <button class="btn btn-light">,</button>
                <button class="btn btn-warning" style="grid-row: 3 / 5; grid-column: 4 / 4;">Un</button>
                <button class="btn btn-success" style="grid-row: 2 / 3; grid-column: 4 / 4;">€</button>
                <button class="btn btn-danger" style="grid-row: 5 / 6; grid-column: 3 / 5;">C</button>

            </div>
        </div>
        <div class="botones card border-0 shadow-sm">
            <div class="card-body gris d-flex flex-column gap-2">
                <button class="btn btn-primary">Cobro<br><small>COBRAR CUENTA</small></button>
                <button class="btn btn-secondary" onclick="printTicket()">Pre<br><small>PRETICKET</small></button>
                <button class="btn btn-success">GT<br><small>GUARDAR CUENTA</small></button>
                <button class="btn btn-info">RT<br><small>RECUPERAR CUENTA</small></button>
                <button class="btn btn-danger" id="delete-all">X<br><small>BORRAR TODO</small></button>
                <button class="btn btn-warning" id="delete-selected">BL<br><small>BORRAR LINEA</small></button>
                {{-- <button class="btn btn-dark">C<br><small>ABRIR CAJON</small></button> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('partials.toast')

<script>
     $("#sidebar").css("display", "none");
     $("#main").css("margin-left", "0px");
    document.querySelectorAll('.category-card').forEach(categoryCard => {
        categoryCard.addEventListener('click', () => {
            const categoryId = categoryCard.getAttribute('data-category-id');
            console.log(categoryId);
            document.querySelectorAll('.product-card').forEach(productCard => {
                productCard.style.display = productCard.getAttribute('data-category-id') === categoryId ? 'block' : 'none';
            });
        });
    });

    let cantidadSeleccionada = '';
    let cambioprecio = false; // Establece esto según el contexto

    document.querySelectorAll('.numpad button').forEach(button => {
        button.addEventListener('click', () => {
            const valor = button.textContent;
            if (!isNaN(valor) || valor === ',') { // Si es un número
                if (valor === ',' && !cantidadSeleccionada.includes('.')) {
                    cantidadSeleccionada += '.';
                } else if (valor !== ',') {
                    cantidadSeleccionada += valor;
                }
            } else if (valor === 'C') { // Limpiar el numpad
                cantidadSeleccionada = '';
            }else if (valor === '€') {
                cambioprecio = true;
            } else if (valor === 'Un') { // Eliminar el último carácter
                cantidadSeleccionada = cantidadSeleccionada.slice(0, -1);
            }
            document.querySelector('.display-cantidad').textContent = `${cantidadSeleccionada}` + (cambioprecio ? '€' : '');
        });
    });
    document.querySelectorAll('.product-card').forEach(productCard => {
        productCard.addEventListener('click', () => {
            const product = productCard.querySelector('.card-title').textContent;
            const price = productCard.querySelector('.text-muted').textContent;
            const cartItems = document.querySelector('.cart-items');

            if (cantidadSeleccionada <= 0) cantidadSeleccionada = 1; // Si no se selecciona cantidad, se asume 1


            const productElement = document.createElement('div');
            productElement.classList.add('d-flex', 'justify-content-between', 'align-items-center');
            if(cambioprecio == false){
                productElement.innerHTML = `
                    <span>${product} x${cantidadSeleccionada}</span>
                    <span>${(parseFloat(price.replace('€', ''))* cantidadSeleccionada).toFixed(2)}€</span>
                `;
            }else{
                productElement.innerHTML = `
                    <span>${product} x 1</span>
                    <span>${parseFloat(cantidadSeleccionada).toFixed(2)}€</span>
                `;
            }
            cambioprecio = false;
            cartItems.appendChild(productElement);
            cantidadSeleccionada = '';
            document.querySelector('.display-cantidad').textContent = `${cantidadSeleccionada}`;

            productElement.addEventListener('click', () => {
                if(document.querySelector('.selected')) {
                    document.querySelector('.selected').classList.remove('selected');
                }
                productElement.classList.add('selected');
            });
            updateCartTotal();
        });
    });
    function updateCartTotal() {
        const items = document.querySelectorAll('.cart-items div');
        let total = 0;
        items.forEach(item => {
            const itemPrice = parseFloat(item.children[1].textContent.replace('€', ''));
            total += itemPrice;
        });
        document.querySelector('.cart-total').textContent = `Total: ${total.toFixed(2)}€`;
    }
    document.getElementById('delete-selected').addEventListener('click', () => {
        const selected = document.querySelector('.cart-items .selected');
        if(selected) {
            selected.remove();
            updateCartTotal();
        }
    });
    document.getElementById('delete-all').addEventListener('click', () => {
        const items = document.querySelectorAll('.cart-items div');
        items.forEach(item => {
            item.remove();
        });
        updateCartTotal();

    });

    function printTicket() {
        let printContents = document.querySelector('.cart').innerHTML;
        let originalContents = document.body.innerHTML;

        let printWindow = window.open('', '_blank', 'width=80mm');
        printWindow.document.write('<html><head><title>Print Ticket</title>');
        printWindow.document.write('<link rel="stylesheet" href="style.css">'); // Asegúrate de incluir el estilo correcto si es necesario
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }


</script>
@endsection
