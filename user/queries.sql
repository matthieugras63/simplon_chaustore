Query to have stock per product, no matter the size

select product.name, sum(stock) from stock inner join product on stock.product_id = product.id group by id;

