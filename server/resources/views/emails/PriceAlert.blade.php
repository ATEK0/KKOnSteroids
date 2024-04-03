
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .bestPrice {
            font-size: 40px;
            font-weight: bold;
            color: #FFBE0B;
        }

        .btn-primary {
            font-weight: bold;
            background-color: #FFBE0B;
            border: #FFBE0B 2px solid;
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: var(--darker-yellow);
            border: var(--darker-yellow) 2px solid;

        }

        .btn-primary-outlined {
            color: #FFBE0B;
            border: 2px solid #FFBE0B;
        }

        .btn-primary-outlined:hover {
            color: white;
            background-color: #FFBE0B;
            border: 2px solid #FFBE0B;
        }
    </style>
</head>

<body class="p-3">
    <h2>Hey {{ $user->name }}</h2>
    <p>Do you remember this alert?</p>
    <p>Your product has reached the target price setted by you in {{ $target->created_at }}</p>
    <p>Your target was <b>{{ $target->target_price }}€</b> and the product is now at <b>{{ $product->lowerprice }}€</b> !</p>
    <section class="row">
        <div class="col-sm d-flex align-items-center justify-content-center">
            <img src="{{ $product->productImage }}" alt="{{ $product->name }}" class="img-fluid p-2">
        </div>
        <div class="col-sm text-start py-4 d-flex justify-content-center flex-column">

            <h3 class="text-capitalize">{{ $product->name }}</h3>
            <small>{{ $product->slug }}</small>

            <p>{{ $product->brand }}</p>
            <br><br>

            <small>best price</small>
            <div class="bestPrice">{{ $product->lowerprice }} €</div>

            <a href="http://localhost:5173/product/{{ $product->slug }}" target="_blank"
                class="btn btn-primary w-fit"><button class="btn btn-primary w-fit">View
                    product</button></a>
        </div>

    </section>
</body>

</html>
