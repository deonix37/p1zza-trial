CREATE TABLE `orders` (
    `order_id` VARCHAR(255) PRIMARY KEY,
    `done` BOOLEAN NOT NULL
);

CREATE TABLE `order_items` (
    `order_id` VARCHAR(255) NOT NULL,
    `order_item_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`order_id`, `order_item_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`)
);
