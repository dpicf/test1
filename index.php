<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <title>тест</title>
</head>
<body>

<form action="" method="post">
  <label for="city_id">ID города</label>
  <input type="number" name="city_id" id="city_id">
  <button type="button" id="add_city">Добавить город</button>
  <div id="cities"></div>
  <br><br>
  <label for="good_id">ID товара</label>
  <input type="number" name="good_id" id="good_id">
  <button type="button" id="add_good">Добавить товар</button>
  <div id="products"></div>
  <br><br><br>
  <button type="button" id="send_query">Отправить запрос</button>
  <pre>
  <div id="result"></div>
  </pre>
</form>

<script>
    let cities = [];
    let products = [];

    $('#add_city').click(function () {
        if ($('#city_id').val() !== '') {
            cities.push($('#city_id').val());
            $('#city_id').val('');
            $('#cities').show().text('добавленные города: ' + cities);
        }
    });

    $('#add_good').click(function () {
        if ($('#good_id').val() !== '') {
            products.push($('#good_id').val());
            $('#good_id').val('');
            $('#products').show().text('добавленные товары: ' + products);
        }
    });

    $('#send_query').click(function () {
        if (cities.length === 0 || products.length === 0) {
            $('#result').show().text('Ошибка! Добавьте города и товары!');
        } else {
            $('#result').show().text('получение данных...');
            $.ajax({
                url: 'back.php',
                type: 'POST',
                data: {region_ids: cities, site_products: products},
                success: function(data) {
                    $('#result').show().text(data);
                }
            })
        }
    });
</script>

</body>
</html>