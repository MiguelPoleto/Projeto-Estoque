@extends("layout.sidebar")
@section("title", "Estoque")
@section("content")

<main>
    <div class="container-fluid p-3">
        <!-- Main Content -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Estoque</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus"></i> Adicionar Produto
            </button>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nome do Produto</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário (R$)</th>
                        <th>Última Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Item -->
                    <tr>
                        <td>1</td>
                        <td>Produto Exemplo</td>
                        <td>Eletrônicos</td>
                        <td>50</td>
                        <td>120,00</td>
                        <td>06/01/2025</td>
                        <td>
                            <button class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detalhes
                            </button>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Remover
                            </button>
                        </td>
                    </tr>
                    <!-- Additional items can go here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Categoria</label>
                            <select class="form-select" id="productCategory">
                                <option selected>Selecione...</option>
                                <option value="1">Eletrônicos</option>
                                <option value="2">Móveis</option>
                                <option value="3">Vestuário</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productQuantity" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="productQuantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Preço Unitário (R$)</label>
                            <input type="text" class="form-control" id="productPrice" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Salvar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</main>

@endsection