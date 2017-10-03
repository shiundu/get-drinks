class CreateProducts < ActiveRecord::Migration[5.1]
  def change
    create_table :products do |t|
      t.string :name
      t.string :quantity 
      t.string :currency
      t.string :price
      t.string :category_id
      t.string :company_id	
      t.timestamps
    end
  end
end
