// $('#add-product-btn').click(function() {
//     window.location.href = 'add-product.php'; // Redirect to the Add Product page
// });

$(document).ready(function () {
  // Configuration object for product types
  const productConfig = {
    dvd: {
      fields: [
        {
          id: "size",
          label: "Size (MB)",
          description: "* Please provide size in MB (numeric only)",
        },
      ],
    },
    book: {
      fields: [
        {
          id: "weight",
          label: "Weight (KG)",
          description: "* Please provide weight in KG (numeric only)",
        },
      ],
    },
    furniture: {
      fields: [
        { id: "height", label: "Height" },
        { id: "width", label: "Width" },
        {
          id: "length",
          label: "Length",
          description:
            "* Please provide dimensions in format H W L  (numeric only)",
        },
      ],
    },
  };

  function generateFields(type) {
    const config = productConfig[type];
    const dynamicFields = $("#dynamic-fields");
    dynamicFields.empty();
    $(".notification").empty(); // Clear any previous notifications

    if (config) {
      // Append fields
      config.fields.forEach((field, index) => {
        dynamicFields.append(`
                <div class="label-input">
                    <label for="${field.id}">${field.label}:</label>
                     <div class="input-notification">
                    <input type="text" id="${field.id}" name="${field.id}">
                      <div  class="notification"></div>
                </div>
                </div>
            `);

        // If the field is the last one, add the notification message
        if (index === config.fields.length - 1) {
          dynamicFields.append(`
                    <div class="notification-bottom">
                        <div  class="description">${field.description}</div>

                    </div>
                `);
        }
      });
    }
  }
  // Store the previous selected value
  let previousType = "";

  $("#productType").change(function () {
    
    let selectedType = $(this).val();
    $(this).attr('selected')
    $(".notification-switcher p").empty();
   
    if (previousType === "") {
      generateFields(selectedType);
    } else if (selectedType !== previousType) {
      $("#product_form")[0].reset(); 
      $("#productType").val(selectedType); 
      generateFields(selectedType);
    }

    // Update the previous type with the current selection
    previousType = selectedType;
  });

  // Form validation and submission
  $("#product_form").on("submit", function (e) {
    e.preventDefault();

    let isValid = true;
    $(".notification").empty();
    $(".notification-switcher").empty();

    //Check required fields
    $("#product_form").find("input").each(function () {
        const $input = $(this);
        const $notification = $input.siblings(".notification"); // Find the sibling notification div
        $notification.empty();

        // Check if the input is empty
        if ($input.val().trim() === "") {
          isValid = false;
          $notification.append("<p>Please submit required data</p>");
        } else {
          // If the input is not empty, check if it is the price field and validate it
          if (
            $input.attr("name") === "price" ||
            $input.attr("name") === "size" ||
            $input.attr("name") === "weight" ||
            $input.attr("name") === "height" ||
            $input.attr("name") === "width" ||
            $input.attr("name") === "length"
          ) {
            let priceValue = $input.val().trim();

            // Check if the value is a valid number
            const parsedValue = parseFloat(priceValue);
            if (isNaN(parsedValue) || !/^\d+(\.\d{1,2})?$/.test(priceValue)) {
              isValid = false;
              $notification.append(
                "<p>Please, provide the data of indicated type</p>"
              );
            } else {
              // Format the value to two decimal places
              if ($input.attr("name") === "price") {
                priceValue = parsedValue.toFixed(2);
              }

              // Update the input field with the formatted value
              $input.val(priceValue);

              // Clear any previous notification if the price is valid
              $notification.empty();
            }
          }
        }
      });

    if (isValid) {
      const selectedType = $("#productType").val();
      if (!selectedType || selectedType === "switcher") {

        isValid = false;
        $(".notification-switcher").append(
          "<p>Please select a product type</p>"
        );
      }
    }

 
    if (isValid) {
      $.ajax({
        url: "src/add-product-db.php",
        method: "POST",
        data: $(this).serialize(),

        success: function (response) {

          if (response.message) {
            $(".notification-sku").html(`<p> ${response.message} </p>`);
          }
          if (response.status == "success") {
            $("#product_form")[0].reset();
            window.location.href = "/";
          }
        },
        error: function (xhr, status, error) {
          console.error("Request failed:", status, error);
          console.error("Response text:", xhr.responseText);
        },
      });
    }
  });

  $("#cancel-btn").click(function () {
    window.location.href = "/";
  });
});
