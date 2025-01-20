<?php

namespace App\Http\Livewire;

use App\Models\Tpv\Category;
use App\Models\Tpv\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsTable extends Component
{
    use WithPagination;

    public $categorias;
    public $buscar;
    public $selectedCategoria = '';
    public $perPage = 10;
    public $sortColumn = 'created_at'; // Columna por defecto
    public $sortDirection = 'desc'; // Dirección por defecto
    protected $services; // Propiedad protegida para los usuarios

    public function mount(){
        $this->categorias = Category::where('inactive',0)->get();
        // $this->actualizarServicios(); // Inicializa los usuarios
    }
    public function render()
    {
        $this->actualizarServicios(); // Ahora se llama directamente en render para refrescar los clientes.
        return view('livewire.products-table', [
            'servicios' => $this->services
        ]);
    }

    protected function actualizarServicios()
    {
        $query = Product::where('product.inactive',0)->when($this->buscar, function ($query) {
                    $query->where('name', 'like', '%' . $this->buscar . '%')
                          ->orWhere('price', 'like', '%' . $this->buscar . '%');
                })
                ->when($this->selectedCategoria, function ($query) {
                    $query->where('category_id', $this->selectedCategoria);
                }) ->join('product_category', 'product.category_id', '=', 'product_category.id')
                ->select('product.*', 'product_category.name as categoria_nombre');

        $query->orderBy($this->sortColumn, $this->sortDirection);

        // Verifica si se seleccionó 'all' para mostrar todos los registros
        $this->services = $this->perPage === 'all' ? $query->get() : $query->paginate(is_numeric($this->perPage) ? $this->perPage : 10);
    }

    public function getServices()
    {
        // Si es necesario, puedes incluir lógica adicional aquí antes de devolver los usuarios
        return $this->services;
    }

    public function aplicarFiltro()
    {
        // Aquí aplicarías los filtros
        // Por ejemplo: $this->filtroEspecifico = 'valor';

        $this->actualizarServicios(); // Luego actualizas la lista de usuarios basada en los filtros
    }
    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }
    public function updating($propertyName)
    {
        if ($propertyName === 'buscar' || $propertyName === 'selectedCategoria') {
            $this->resetPage(); // Resetear la paginación solo cuando estos filtros cambien.
        }
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }
}
