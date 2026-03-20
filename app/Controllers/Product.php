<?php 
namespace App\Controllers;
use App\Models\ProductsModel;
class Product extends BaseController{
    public function index() {
        $productsModel = new ProductsModel();
        $data['products'] = $productsModel->findAll();
        return view('products/index', $data);
    }

    public function update() {
        $id = $this->request->getPost('pk_product');
        $productsModel = new ProductsModel();
        $data = [
            'product'     => $this->request->getPost('product'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'stock_min'   => $this->request->getPost('stock_min'),
            'stock_max'   => $this->request->getPost('stock_max'),
        ];

        if ($productsModel->update($id, $data)) {
            return redirect()->back()->with('msg', 'Producto actualizado con éxito');
        }
        
        return redirect()->back()->with('error', 'Error al actualizar');
    }
} 