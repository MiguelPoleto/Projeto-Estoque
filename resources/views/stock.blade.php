@extends("layout.sidebar")
@section("title", "Estoque")
@section("content")

<main>
    <div class="container-fluid p-3">
        <!-- Main Content -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Estoque</h3>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#buyProductModal">
                    <i class="fas fa-plus"></i> Compra
                </button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#sellProductModal">
                    <i class="fas fa-plus"></i> Venda
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Id</th>
                        <th>Nome do Produto</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço Médio (un)</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                @foreach($products as $product)
                <tbody>
                    <!-- Example Item -->
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            @switch($product->category)
                            @case('eletronic')
                            Eletrônicos
                            @break
                            @case('furniture')
                            Móveis
                            @break
                            @case('raw_material')
                            Vestuário
                            @break
                            @case('others')
                            Outros
                            @break
                            @endswitch
                        </td>
                        <td>{{ $product->amount }}</td>
                        <td>R$ {{ $product->price }}</td>
                        <td>{{ $product->is_active == 1 ? "Ativo" : "Inativo" }}</td>
                        <td>
                            <button class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detalhes
                            </button>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <form action="{{ route('stock.delete') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Remover
                                </button>
                            </form>
                        </td>
                    </tr>
                    <!-- Additional items can go here -->
                </tbody>
                @endforeach
            </table>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stock.new') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Abas -->
                        <ul class="nav nav-tabs mb-3" id="productModalTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-controls="basic-info" aria-selected="true">Informações Básicas</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="additional-info-tab" data-bs-toggle="tab" data-bs-target="#additional-info" type="button" role="tab" aria-controls="additional-info" aria-selected="false">Informações Adicionais</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="productModalContent">
                            <!-- Primeira Página -->
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="product_id" class="form-label">ID do Produto <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control" id="product_id" name="product_id" placeholder="Digite o ID do produto" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nome do Produto <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do produto" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">Categoria <span class="text-danger">*</span></label>
                                        <select class="form-select" id="category" name="category" required>
                                            <option value="" selected>Selecione...</option>
                                            <option value="eletronic">Eletrônicos</option>
                                            <option value="furniture">Móveis</option>
                                            <option value="raw_material">Vestuário</option>
                                            <option value="others">Outros</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="unit" class="form-label">Unidade de Medida <span class="text-danger">*</span></label>
                                        <select class="form-select" id="unit" name="unit" required>
                                            <option value="pcs">Peças (pcs)</option>
                                            <option value="kg">Quilogramas (kg)</option>
                                            <option value="g">Gramas (g)</option>
                                            <option value="l">Litros (l)</option>
                                            <option value="ml">Mililitros (ml)</option>
                                            <option value="m">Metros (m)</option>
                                            <option value="cm">Centímetros (cm)</option>
                                            <option value="un">Unidades (un)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label">Quantidade <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="amount" name="amount" min="1" placeholder="Digite a quantidade" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price" class="form-label">Preço Unitário (R$) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Digite o preço unitário" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda Página -->
                            <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Digite uma descrição detalhada do produto"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="Digite o SKU do produto">
                                </div>
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Código de Barras</label>
                                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Digite o código de barras">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Nome do Fornecedor</label>
                                    <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Digite o nome do fornecedor">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_contact" class="form-label">Contato do Fornecedor</label>
                                    <input type="tel" class="form-control" id="supplier_contact" name="supplier_contact"
                                        placeholder="Digite o contato do fornecedor" maxlength="11" minlength="11" onkeyup="phoneFormatted(this)">
                                </div>
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="brand" name="brand"
                                        placeholder="Digite a marca do produto">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Localização no Estoque</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Digite a localização">
                                </div>
                                <div class="mb-3">
                                    <label for="minimum_stock" class="form-label">Estoque Mínimo</label>
                                    <input type="number" class="form-control" id="minimum_stock" name="minimum_stock" min="1" value="1" placeholder="Digite o estoque mínimo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="saveProduct">Salvar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Buy Product Modal -->
    <div class="modal fade" id="buyProductModal" tabindex="-1" aria-labelledby="buyProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyProductModalLabel">Compra de Produtos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form form action="{{ route('stock.buy') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="product_id" class="form-label">
                                ID do Produto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="product_id" name="product_id" placeholder="Digite o ID do produto" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_amount" class="form-label">
                                Quantidade <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="buy_amount" name="buy_amount" min="1" placeholder="Digite a quantidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">
                                Preço Unitário de Compra (R$) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="buy_price" name="buy_price" placeholder="Digite o preço unitário" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_total_price" class="form-label">
                                Preço Total (R$)
                            </label>
                            <input type="text" class="form-control" id="buy_total_price" placeholder="Calculado automaticamente" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveBuyProduct">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sell Product Modal -->
    <div class="modal fade" id="sellProductModal" tabindex="-1" aria-labelledby="sellProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sellProductModalLabel">Venda de Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="product_id" class="form-label">
                                ID do Produto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="product_id" name="product_id" placeholder="Digite o ID do produto" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_amount" class="form-label">
                                Quantidade <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="sell_amount" name="sell_amount" min="1" placeholder="Digite a quantidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">
                                Preço Unitário de Venda(R$) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="sell_price" name="sell_price" placeholder="Digite o preço unitário" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_total_price" class="form-label">
                                Preço Total (R$)
                            </label>
                            <input type="text" class="form-control" id="sell_total_price" placeholder="Calculado automaticamente" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveSellProduct">Salvar</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    function phoneFormatted(input) {
        var phone = input.value.replace(/\D/g, '');
        phone = phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
        input.value = phone;
    }

    document.getElementById("price").addEventListener("change", function() {
        this.value = parseFloat(this.value).toFixed(2);
    });
</script>

@endsection

@push('scripts')
<script src="{{ asset('js/stock.js') }}"></script>
@endpush

@push('styles')
<link href="{{ asset('css/stock.css') }}" rel="stylesheet">
@endpush