$(document).ready(function () {
  // Declare the chart variables in a broader scope
  var salesChart; 
  var productsChart;

  // Initialize the sales chart with empty data
  function initializeSalesChart() {
      var options = {
          chart: {
              type: 'bar',
              height: 300
          },
          series: [{
              name: 'Total Sales',
              data: [] // Initialize with empty data
          }],
          xaxis: {
              categories: [] // Initialize with empty categories
          }
      };

      // Create the chart instance and render it
      salesChart = new ApexCharts(document.querySelector("#chart_funnel"), options);
      salesChart.render();
  }

  // Initialize the products chart with empty data
  function initializeProductsChart() {
      var options = {
          chart: {
              type: 'pie',
              height: 300
          },
          series: [], // Initialize with empty data
          labels: []  // Initialize with empty labels
      };

      // Create the chart instance and render it
      productsChart = new ApexCharts(document.querySelector("#products_chart"), options);
      productsChart.render();
  }

  // Function to fetch sales data based on the selected filter
  function fetchSalesData(filter) {
      $.ajax({
          url: 'fetch_sales_data.php', // URL to the PHP script
          type: 'GET',
          data: { filter: filter }, // Send the selected filter to the PHP script
          dataType: 'json',
          success: function (response) {
              // Extract product names and sales data
              var productNames = response.map(item => item.product_name);
              var totalSales = response.map(item => item.total_sales);

              // Update the sales chart with new data
              updateSalesChart(productNames, totalSales);
          },
          error: function () {
              console.error('Error fetching sales data.');
          }
      });
  }

  // Function to update the sales chart with new data
  function updateSalesChart(productNames, totalSales) {
      salesChart.updateOptions({
          xaxis: {
              categories: productNames // Update the categories on the x-axis
          }
      });

      salesChart.updateSeries([{
          name: 'Total Sales',
          data: totalSales // Update the series data
      }]);
  }

  // Function to fetch products data for the pie chart
  function fetchProductsData() {
      $.ajax({
          url: 'fetch_products_data.php', // URL to the PHP script
          type: 'GET',
          dataType: 'json',
          success: function (response) {
              // Extract product names, quantities, and statuses
              var productNames = response.map(item => item.product_name);
              var productQuantities = response.map(item => item.product_qty);

              // Update the products chart with new data
              updateProductsChart(productNames, productQuantities);
          },
          error: function () {
              console.error('Error fetching products data.');
          }
      });
  }

  // Function to update the products chart with new data
  function updateProductsChart(productNames, productQuantities) {
      productsChart.updateOptions({
          labels: productNames // Update the labels for the pie chart
      });

      productsChart.updateSeries(productQuantities); // Update the series data
  }

  // Event listener for the filter dropdown change
  $('.selector-sales').on('change', function () {
      var selectedFilter = $(this).val().toLowerCase(); // Get the selected filter and convert to lowercase
      fetchSalesData(selectedFilter); // Fetch data based on the selected filter
  });

  // Initialize the charts on page load
  initializeSalesChart();
  initializeProductsChart();

  // Fetch and render sales data on page load with the default filter
  fetchSalesData('day');

  // Fetch and render products data on page load
  fetchProductsData();

  setInterval(fetchProductsData, 3000); // Update products data every 3 seconds
});