<?php include 'views/partials/header.php'; ?>

<div class="container">
    <form id="product_form" method="POST">
        <div class="header">
            <a href="/">
                <h1 class="title">Product Add</h1>
            </a>
            <div class="btns">
                <button type="submit" name="save" id="save-btn">Save</button>
                <button type="button" name="cancel" id="cancel-btn">Cancel</button>
            </div>
        </div>
        <div class="form-container">
            <div class="label-input">
                <label class="sku-label" for="sku">SKU:</label>
                <div class="input-notification">
                    <input type="text" id="sku" name="sku">
                    <div class="notification  notification-sku" id="error-sku"></div>
                </div>
            </div>
            <div class="label-input">
                <label for="name">Name:</label>
                <div class="input-notification">
                    <input type="text" id="name" name="name">
                    <div class="notification" id="error-name"></div>
                </div>
            </div>
            <div class="label-input">
                <label for="price">Price ($):</label>
                <div class="input-notification">
                    <input type="text" id="price" name="price">
                    <div class="notification" id="error-price"></div>
                </div>
            </div>
            <div class="label-input label-input-switcher">
                <label for="type">Type Switcher:</label>
                <div class="input-notification">
                    <select id="productType" name="type">
                        <option value="" disabled selected>Type Switcher</option>
                        <option value="dvd">DVD</option>
                        <option value="book">Book</option>
                        <option value="furniture">Furniture</option>
                    </select>
                    <div class="notification-switcher" id="error-type"></div>
                </div>
            </div>
            <div class="label-input">
                <div id="dynamic-fields"></div>
            </div>
        </div>
    </form>
</div>

<?php include 'views/partials/footer.php'; ?>
