<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribucija Hrane</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('slike/pozadina.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
        .container {
            margin-top: 100px;
            margin-bottom: 100px;  
            flex: 1;
            background-color: rgba(255, 255, 255, 0.8); /* Bela pozadina sa prozirnošću */
            padding: 20px;
            border-radius: 8px;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .cart {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s;
        }
        .cart:hover {
            background-color: #0056b3;
        }
        .cart.animate {
            transform: scale(1.2);
        }
        .cart img {
            width: 30px; /* Smanjite veličinu slike */
            height: 30px;
        }
        .cart-modal {
            display: none;
            position: fixed;
            bottom: 100px;
            right: 20px;
            width: 300px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border-radius: 8px;
        }
        .cart-modal-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .cart-modal-body {
            padding: 10px;
            max-height: 300px;
            overflow-y: auto;
        }
        .cart-modal-footer {
            padding: 10px;
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .cart-item-name {
            flex: 1;
        }
        .cart-item-quantity {
            margin-left: 10px;
        }
        .cart-item-price {
            margin-left: 10px;
        }
        .cart-item-remove {
            margin-left: 10px;
            cursor: pointer;
            color: red;
        }
    </style>
</head>
<body>
<?php
session_start();
?>
<!-- Navigacioni bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Distribucija Hrane</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="login.php">Admin</a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <span class="navbar-text">Zdravo, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Odjavi se</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Korisnik Login</button>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

    <div class="container">
        <h1 class="my-4 text-center">Proizvodi</h1>
        
        <!-- Filter za pretragu -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <input type="text" id="search" class="form-control" placeholder="Pretraži proizvode...">
            </div>
        </div>

        <!-- Filter za kategorije -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <select id="category-filter" class="form-control">
                    <option value="">Sve kategorije</option>
                    <option value="Voće">Voće</option>
                    <option value="Povrće">Povrće</option>
                    <option value="Meso">Meso</option>
                    <option value="Mlečni proizvodi">Mlečni proizvodi</option>
                    <option value="Pekarski proizvodi">Pekarski proizvodi</option>
                </select>
            </div>
        </div>

        <!-- Lista proizvoda -->
        <div class="row" id="product-list">
            <?php
            // Uključivanje fajla za konekciju sa bazom podataka
            include 'db_connect.php';

            // Dohvatanje proizvoda
            $sql = "SELECT * FROM proizvodi";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-md-6 mb-4 product-item" data-category="' . $row["kategorija"] . '">';
                    echo '<div class="card h-100">';
                    if (!empty($row["slika"])) {
                        echo '<a href="proizvod.php?id=' . $row["id"] . '"><img class="card-img-top" src="' . $row["slika"] . '" alt="' . $row["ime"] . '"></a>';
                    }
                    echo '<div class="card-body">';
                    echo '<h4 class="card-title"><a href="proizvod.php?id=' . $row["id"] . '">' . $row["ime"] . '</a></h4>';
                    echo '<h5>' . $row["cena"] . ' din</h5>';
                    echo '<p class="card-text">' . $row["opis"] . '</p>';
                    echo '<button class="btn btn-primary add-to-cart" data-id="' . $row["id"] . '" data-name="' . $row["ime"] . '" data-price="' . $row["cena"] . '">Dodaj u korpu</button>';
                    echo '</div>';
                    echo '<div class="card-footer">';
                    echo '<small class="text-muted">' . $row["kategorija"] . '</small>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12"><p class="text-center">Nema pronađenih proizvoda.</p></div>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Distribucija Hrane. Sva prava zadržana.</p>
    </footer>

    <div class="cart" id="cart">
        <img src="slike/Korpa.png" alt="Korpa">
    </div>

    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-header">
            <h5>Vaša korpa</h5>
        </div>
        <div class="cart-modal-body" id="cartItems">
            <p>Korpa je prazna.</p>
        </div>
        <div class="cart-modal-footer">
            <button class="btn btn-primary" id="checkout">Završi porudžbinu</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        // Funkcionalnost filtera za pretragu
        $('#search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#product-list .product-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Funkcionalnost filtera za kategorije
        $('#category-filter').on('change', function() {
            var category = $(this).val();
            if (category) {
                $('#product-list .product-item').filter(function() {
                    $(this).toggle($(this).data('category') === category);
                });
            } else {
                $('#product-list .product-item').show();
            }
        });

        // Funkcionalnost korpe
        var cart = [];
        $('#cart').on('click', function() {
            $('#cartModal').toggle();
        });

        $('.add-to-cart').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');
            var item = { id: id, name: name, price: price, quantity: 1 };

            var exists = cart.find(function(element) {
                return element.id == id;
            });

            if (exists) {
                exists.quantity += 1;
            } else {
                cart.push(item);
            }

            updateCart();
            animateCart();
        });

        function updateCart() {
            var cartItems = $('#cartItems');
            cartItems.empty();

            if (cart.length === 0) {
                cartItems.append('<p>Korpa je prazna.</p>');
            } else {
                cart.forEach(function(item) {
                    cartItems.append('<div class="cart-item"><span class="cart-item-name">' + item.name + '</span><span class="cart-item-quantity">x ' + item.quantity + '</span><span class="cart-item-price">' + item.price + ' din</span><span class="cart-item-remove" data-id="' + item.id + '">&times;</span></div>');
                });
            }

            $('.cart-item-remove').on('click', function() {
                var id = $(this).data('id');
                cart = cart.filter(function(item) {
                    return item.id != id;
                });
                updateCart();
            });
        }

        function animateCart() {
            $('#cart').addClass('animate');
            setTimeout(function() {
                $('#cart').removeClass('animate');
            }, 300);
        }

        $('#checkout').on('click', function() {
            if (cart.length === 0) {
                alert('Korpa je prazna.');
                return;
            }

            <?php if (!isset($_SESSION['user_id'])): ?>
                alert('Morate biti prijavljeni da biste završili porudžbinu.');
                return;
            <?php endif; ?>

            $.ajax({
                url: 'checkout.php',
                method: 'POST',
                data: { cart: cart },
                success: function(response) {
                    alert('Porudžbina je uspešno završena.');
                    cart = [];
                    updateCart();
                    $('#cartModal').hide();
                }
            });
        });
    </script>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Korisnik Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" method="post" action="user_login.php">
                        <div class="form-group">
                            <label for="loginEmail">Email adresa</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Šifra</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Prijavi se</button>
                    </form>
                    <p class="mt-3">Nemate nalog? <button class="btn btn-link" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Registrujte se</button></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registracija Korisnika</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" method="post" action="user_register.php">
                        <div class="form-group">
                            <label for="registerIme">Ime</label>
                            <input type="text" class="form-control" id="registerIme" name="ime" required>
                        </div>
                        <div class="form-group">
                            <label for="registerPrezime">Prezime</label>
                            <input type="text" class="form-control" id="registerPrezime" name="prezime" required>
                        </div>
                        <div class="form-group">
                            <label for="registerEmail">Email adresa</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Šifra</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registruj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>