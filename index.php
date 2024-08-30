<?php  include './views/partials/header.php'; ?>

    <div class="container">
        <form id="delete-form" action="src/delete-products.php" method="POST">
        <div class="header">

            <h1 class="title">Product List</h1>
            <div class="btns">
                <button type="submit" name="add" formaction="add-product.php" id="add-product-btn">ADD</button>
                <button type="submit" name="delete" id="delete-product-btn">MASS DELETE</button>

            </div>
        </div>
        <!-- Form for deleting selected products -->
            <div class="grid-container">
                <?php foreach ($products as $product): ?>

                    <div class="grid-item">
                        <input type="checkbox" name="products[]" value="<?php echo htmlspecialchars($product->getId()); ?>" class="delete-checkbox">
                        <div class="product-info">
                            <p><strong>SKU:</strong> <?php echo htmlspecialchars($product->getSku()); ?></p>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($product->getName()); ?></p>
                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($product->getPrice()); ?></p>
                            <?php foreach ($product->getAdditionalAttributes() as $key => $value): ?>
                <p><strong><?php echo htmlspecialchars(ucfirst($key)); ?>:</strong> <?php echo htmlspecialchars($value); ?></p>
            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

          
        </form>
    </div>

    <?php include 'views/partials/footer.php'; ?>