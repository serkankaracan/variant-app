<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Variants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            background-color: #444;
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #555;
        }

        .content {
            padding: 20px;
            background-color: #fff;
            margin-top: 20px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <h1>Edit Variant</h1>
    </header>
    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('variants.index') }}">Variants</a>
        <a href="{{ route('products.index') }}">Products</a>
    </nav>
    <div class="container">
        <div class="content">
            <h1>Edit Variant</h1>

            <form method="POST" action="{{ route('variants.update', $variant->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Variant Name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ $variant->name }}">
                </div>

                <div class="form-group">
                    <label for="values">Variant Values:</label>
                    @foreach ($variantValues as $variantValue)
                        <input type="text" class="form-control" id="values" name="values[]"
                            value="{{ $variantValue->value }}">
                            <form id="deleteVariantValueForm" action="{{ route('variantValues.destroy', $variantValue->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Update Variant</button>
            </form>

        </div>
    </div>
    <footer>
        <p>&copy; 2024 Website</p>
    </footer>
</body>

</html>
