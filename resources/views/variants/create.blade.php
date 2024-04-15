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
        <h1>Create Variant</h1>
    </header>
    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('variants.index') }}">Variants</a>
        <a href="{{ route('products.index') }}">Products</a>
    </nav>
    <div class="container">
        <div class="content">
            <h1>Create Variant</h1>

            @if ($errors->any())
                <div style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="variantForm" method="POST" action="{{ route('variants.store') }}">
                @csrf
                <div class="form-group">
                    <label for="variant">Variant Name:</label>
                    <input type="text" id="variant" name="variant" class="form-control" required>
                </div>
                <div id="variants">
                    <div class="variant">
                        <label for="value1">Value 1:</label>
                        <input type="text" id="value1" name="variants[]" class="form-control" required>
                        <button type="button" class="btn btn-primary add-value">Add Value</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save Variant</button>
            </form>

            <script>
                $(document).ready(function() {
                    let valueIndex = 2;

                    $('.add-value').click(function() {
                        const newVariantDiv = $(`<div class="variant">
                            <label for="value${valueIndex}">Value ${valueIndex}:</label>
                            <input type="text" id="value${valueIndex}" name="variants[]" class="form-control" required>
                        </div>`);

                        $('#variants').append(newVariantDiv);

                        valueIndex++;
                    });

                    $('#variantForm').submit(function() {
                        const variantsCount = $('input[name="variants[]"]').length;
                        if (variantsCount === 0) {
                            alert('Please add at least one variant value.');
                            return false;
                        }
                    });
                });
            </script>

            <script>
                /*
                document.addEventListener('DOMContentLoaded', function() {
                    const variantsDiv = document.getElementById('variants');
                    let variantIndex = 1;

                    const addVariantButton = document.querySelector('.add-variant');
                    addVariantButton.addEventListener('click', function() {
                        const newVariantDiv = document.createElement('div');
                        newVariantDiv.classList.add('variant');

                        const label = document.createElement('label');
                        label.textContent = 'Value ' + variantIndex + ':';

                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'variants[]';
                        input.required = true;

                        newVariantDiv.appendChild(label);
                        newVariantDiv.appendChild(input);

                        variantsDiv.appendChild(newVariantDiv);

                        variantIndex++;
                    });
                });
                */
            </script>

        </div>
    </div>
    <footer>
        <p>&copy; 2024 Website</p>
    </footer>
</body>

</html>
