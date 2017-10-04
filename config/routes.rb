Rails.application.routes.draw do
  # get 'welcome/index'
 
  resources :products

  namespace :api do 
  	namespace :v1 do 
  		resources :api_products, only: [:index, :show] 
  	end 
  end
 
  # root 'welcome#index'
end