class Api::V1::ApiProductsController < Api::V1::BaseController
  # before_action :set_product, only: [:show, :edit, :update, :destroy]

  # GET /api_products_controller
  # GET /api_products_controller.json
  def index
    respond_with Product.all
  end

  def show
    img = params[:id].to_s + '.png'
    send_file 'public/images/products/'+img, type: 'image/png', disposition: 'inline'
  end 
end
