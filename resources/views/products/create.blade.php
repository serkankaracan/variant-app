<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Products</title>
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

        .variant-options {
            margin-top: 10px;
        }

        .variant-option {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Products</h1>
    </header>
    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('variants.index') }}">Variants</a>
        <a href="{{ route('products.index') }}">Products</a>
    </nav>
    <div class="container">
        <h2>Add Product</h2>
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <h4>Variants:</h4>
            <div class="form-group">
                @foreach ($variants as $variant)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="variant-checkbox" name="selected_variants[]" value="{{ $variant->id }}">
                            {{ $variant->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div id="variantOptions" class="form-group">
                <!-- Bu alana JavaScript ile kombinasyonlar eklenecek -->
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Variant Combination</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>SKU</th>
                </tr>
            </thead>
            <tbody id="variantTableBody">
                <!-- Burada kombinasyonlar tabloya dinamik olarak eklenecek -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var variantValues = {!! $variantValues !!};

            // Tümünü Seç checkbox'ı
            $('#selectAll').click(function() {
                $('.variant-select').prop('checked', $(this).prop('checked'));
            });

            $('.variant-checkbox').change(function() {
                var selectedVariants = [];
                $('.variant-checkbox:checked').each(function() {
                    selectedVariants.push($(this).val());
                });

                var variantOptions = [];
                selectedVariants.forEach(function(variantId) {
                    var variantName = $('.variant-checkbox[value="' + variantId + '"]').closest('.checkbox').text().trim();
                    variantName = variantName.replace(':', ''); // : işaretini kaldır
                    var values = variantValues[variantId];
                    var optionGroup = [];
                    values.forEach(function(value) {
                        optionGroup.push(variantName + ': ' + value);
                    });
                    variantOptions.push(optionGroup);
                });

                var html = '';
                if (variantOptions.length > 0) {
                    var combinations = cartesian(variantOptions);
                    combinations.forEach(function(combination, index) {
                        html += '<tr>';
                        html += '<td><input type="checkbox" class="variant-select" name="selected_combinations[]" value="' + index + '"></td>';
                        html += '<td>' + combination.join(' - ') + '</td>';
                        html += '<td><input type="text" class="form-control" name="stock[]" placeholder="Stock"></td>';
                        html += '<td><input type="text" class="form-control" name="price[]" placeholder="Price"></td>';
                        html += '<td><input type="text" class="form-control" name="sku[]" placeholder="SKU"></td>';
                        html += '</tr>';
                    });
                } else {
                    html += '<tr><td colspan="4">No combinations available.</td></tr>';
                }

                $('#variantTableBody').html(html);
            });

            function cartesian(args) {
                var r = [], max = args.length-1;
                function helper(arr, i) {
                    for (var j=0, l=args[i].length; j<l; j++) {
                        var a = arr.slice(0); // clone arr
                        a.push(args[i][j]);
                        if (i==max)
                            r.push(a);
                        else
                            helper(a, i+1);
                    }
                }
                helper([], 0);
                return r;
            }
        });
    </script>

    </div>
    <!--footer>
        <p>&copy; 2024 Website</p>
    </footer-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--script>
        $(document).ready(function() {
            $('.variant-checkbox').change(function() {
                updateVariantOptions();
            });

            function updateVariantOptions() {
                let selectedVariants = [];
                $('.variant-checkbox:checked').each(function() {
                    selectedVariants.push($(this).parent().text().trim());
                });
                console.log(selectedVariants);

                let combinations = getCombinations(selectedVariants);
                displayCombinations(combinations);
            }

            function getCombinations(selectedVariants) {
                let combinations = [
                    []
                ];
                for (let variant of selectedVariants) {
                    let temp = [];
                    for (let combination of combinations) {
                        for (let value of variant.split('\n')) {
                            temp.push(combination.concat(value.trim()));
                        }
                    }
                    combinations = temp;
                }
                return combinations;
            }

            function displayCombinations(combinations) {
                let variantOptionsDiv = $('#variantOptions');
                variantOptionsDiv.empty();
                variantOptionsDiv.show();

                for (let i = 0; i < combinations.length; i++) {
                    let combination = combinations[i];
                    let optionText = combination.join(' - ');
                    let optionElement = $('<div class="variant-option">' + optionText + '</div>');
                    variantOptionsDiv.append(optionElement);
                }
            }
        });
    </script-->
</body>

</html>
