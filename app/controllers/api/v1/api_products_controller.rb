class Api::V1::ApiProductsController < Api::V1::BaseController
  before_action :set_product, only: [:show, :edit, :update, :destroy]

  # GET /products
  # GET /products.json
  def index
    respond_with Product.all
  end
end
