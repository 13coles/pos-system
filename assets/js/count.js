$(document).ready(function () {
    
    // Function to fetch the total number of brands
    function fetchBrandCount() {
        $.ajax({
            url: 'config/ajaxProcess/fetch.php', // Path to your PHP script
            type: 'GET',
            data: { action: 'Count_tbl_brands' },
            dataType: 'json',
            success: function (response) {
                // Update the brand count in the DOM
                $('.total-brands').text(response.total_brands);
            },
            error: function () {
                console.error('Error fetching brand count.');
            }
        });
    }

    // Function to fetch the total number of products
    function fetchProductCount() {
        $.ajax({
            url: 'config/ajaxProcess/fetch.php', // Path to your PHP script
            type: 'GET',
            data: { action: 'Count_tbl_products' },
            dataType: 'json',
            success: function (response) {
                // Update the product count in the DOM
                $('.total-products').text(response.total_products);
            },
            error: function () {
                console.error('Error fetching product count.');
            }
        });
    }

    function fetchTotalSales() {
        $.ajax({
            url: 'config/ajaxProcess/fetch.php', // Path to your PHP script
            type: 'GET',
            data: { action: 'Count_total_sales' },
            dataType: 'json',
            success: function (response) {
                // Update the total sales in the DOM
                $('.total-sales').text(response.total_sales);
            },
            error: function () {
                console.error('Error fetching total sales.');
            }
        });
    }

    function fetchTotalSold() {
        $.ajax({
            url: 'config/ajaxProcess/fetch.php', // Path to your PHP script
            type: 'GET',
            data: { action: 'Count_total_sold' },
            dataType: 'json',
            success: function (response) {
                // Update the total sales in the DOM
                $('.total-sold').text(response.total_sold);
            },
            error: function () {
                console.error('Error fetching total sold.');
            }
        });
    }

    // Call the functions on page load
    fetchBrandCount();
    fetchProductCount();
    fetchTotalSales();
    fetchTotalSold();
  

    // Optionally, call the functions periodically to update the count in real-time
    setInterval(fetchBrandCount, 3000); // Update brands every 3 seconds
    setInterval(fetchProductCount, 3000); 
    setInterval(fetchTotalSales, 3000);
    setInterval(fetchTotalSold, 3000);
   
});
