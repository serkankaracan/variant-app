<!-- resources/views/categories/index.blade.php -->
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
        <h1>Variants</h1>
    </header>
    <nav>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('categories.index') }}">Categories</a>
        <a href="{{ route('variants.index') }}">Variants</a>
        <a href="{{ route('products.index') }}">Products</a>
    </nav>
    <div class="container">
        <div class="content">
            <h1>Variants</h1>

            <a href="{{ route('variants.create') }}">Add New Variant</a>

            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($variants as $variant)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $variant->id }}</td>
                    <td>{{ $variant->name }}</td>
                    <td>
                        <a href="{{ route('variants.edit', $variant->id) }}">Edit</a>
                        <form action="{{ route('variants.destroy', $variant->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Website</p>
    </footer>
</body>
</html>
