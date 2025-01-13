@extends("layout.sidebar")
@section("title", "Estoque")
@section("content")

<style>
    #confirmationCard,
    #confirmationEditCard {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 1050;
        width: 24rem;
        /* Ligeiramente maior para acomodar o layout */
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        padding: 2rem;
        font-family: "Arial", sans-serif;
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Título em destaque */
    #confirmationCard h4,
    #confirmationEditCard h4 {
        font-size: 1.5rem;
        color: #333333;
        font-weight: bold;
        margin-bottom: 1.5rem;
        text-align: center;
        text-transform: uppercase;
        border-bottom: 2px solid #007bff;
        /* Linha decorativa */
        padding-bottom: 0.5rem;
    }

    /* Informações centralizadas */
    #confirmationCard p,
    #confirmationEditCard p {
        font-size: 1rem;
        color: #555555;
        margin: 0.5rem 0;
        text-align: left;
    }

    /* Destaque nos valores */
    #confirmationCard strong,
    #confirmationEditCard strong {
        color: #222222;
        font-weight: bold;
    }

    /* Container para botões */
    .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 1.5rem;
    }

    /* Botão de cancelar */
    .button-container .btn-cancel {
        background-color: #dc3545;
        /* Vermelho Bootstrap */
        color: #ffffff;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-container .btn-cancel:hover {
        background-color: #b02a37;
        /* Vermelho mais escuro no hover */
    }

    /* Botão de confirmar */
    .button-container .btn-confirm {
        background-color: #28a745;
        /* Verde Bootstrap */
        color: #ffffff;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-container .btn-confirm:hover {
        background-color: #218838;
        /* Verde mais escuro no hover */
    }

    /* Animação para suavidade ao aparecer */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -60%);
        }

        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }
</style>

<main>
    <div class="container-fluid p-3">
        <!-- Main Content -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Estoque</h3>
            <div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal">
                    <i class="fas fa-plus"></i> Venda / Compra
                </button>
            </div>
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
                        <th>Id do Produto</th>
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
                        <td>123</td>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
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
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="product_id" class="form-label">
                                            ID do Produto <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="product_id" placeholder="Digite o ID do produto" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">
                                            Nome do Produto <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="name" placeholder="Digite o nome do produto" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="category" class="form-label">
                                            Categoria <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="category" required>
                                            <option selected>Selecione...</option>
                                            <option value="eletronic">Eletrônicos</option>
                                            <option value="furniture">Móveis</option>
                                            <option value="raw_material">Vestuário</option>
                                            <option value="others">Outros</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="unit" class="form-label">
                                            Unidade de Medida <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="unit" required>
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
                                        <label for="amount" class="form-label">
                                            Quantidade <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" id="amount" min="1" placeholder="Digite a quantidade" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price" class="form-label">
                                            Preço Unitário (R$) <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="price" placeholder="Digite o preço unitário" required>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Segunda Página -->
                        <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                            <form>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descrição</label>
                                    <textarea class="form-control" id="description" rows="3" placeholder="Digite uma descrição detalhada do produto"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" placeholder="Digite o SKU do produto">
                                </div>
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Código de Barras</label>
                                    <input type="text" class="form-control" id="barcode" placeholder="Digite o código de barras">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier" class="form-label">Fornecedor</label>
                                    <input type="text" class="form-control" id="supplier" placeholder="Digite o nome do fornecedor">
                                </div>
                                <div class="mb-3">
                                    <label for="supplier_contact" class="form-label">Contato do Fornecedor</label>
                                    <input type="text" class="form-control" id="supplier_contact" placeholder="Digite o contato do fornecedor">
                                </div>
                                <div class="mb-3">
                                    <label for="location" class="form-label">Localização no Estoque</label>
                                    <input type="text" class="form-control" id="location" placeholder="Digite a localização">
                                </div>
                                <div class="mb-3">
                                    <label for="minimum_stock" class="form-label">Estoque Mínimo</label>
                                    <input type="number" class="form-control" id="minimum_stock" min="1" placeholder="Digite o estoque mínimo">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveProduct">Salvar Produto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Card -->
    <div class="card shadow-lg position-fixed top-50 start-50 translate-middle d-none" id="confirmationCard" style="width: 24rem; z-index: 1050;">
        <div class="card-body">
            <h4 class="card-title text-center text-uppercase mb-3" style="font-weight: bold; border-bottom: 2px solid #007bff; padding-bottom: 0.5rem;">
                Confirmar Informações
            </h4>
            <p class="card-text">
                <strong>Nome:</strong> <span id="confirmName"></span><br>
                <strong>Categoria:</strong> <span id="confirmCategory"></span><br>
                <strong>Quantidade:</strong> <span id="confirmAmount"></span><br>
                <strong>Preço Unitário:</strong> R$ <span id="confirmPrice"></span>
            </p>
            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-danger" id="cancelConfirmation">Cancelar</button>
                <button class="btn btn-success" id="confirmSave">Confirmar</button>
            </div>
        </div>
    </div>


    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Venda / Compra de Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">
                                ID do Produto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="product_id" placeholder="Digite o ID do produto" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_option" class="form-label">
                                Opção <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="product_option" required>
                                <option value="" selected>Selecione...</option>
                                <option value="1">Venda</option>
                                <option value="2">Compra</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sale_amount" class="form-label">
                                Quantidade <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="sale_amount" min="1" placeholder="Digite a quantidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_price" class="form-label">
                                Preço Unitário (R$) <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="sale_price" placeholder="Digite o preço unitário" required>
                        </div>
                        <div class="mb-3">
                            <label for="sale_total_price" class="form-label">
                                Preço Total (R$)
                            </label>
                            <input type="text" class="form-control" id="sale_total_price" placeholder="Calculado automaticamente" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="saveSaleProduct">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Sales Card -->
    <div class="card shadow-lg position-fixed top-50 start-50 translate-middle d-none" id="confirmationEditCard" style="width: 24rem; z-index: 1050;">
        <div class="card-body">
            <h4 class="card-title text-center text-uppercase mb-3" style="font-weight: bold; border-bottom: 2px solid #007bff; padding-bottom: 0.5rem;">
                Confirmar Informações
            </h4>
            <p class="card-text">
                <strong>ID:</strong> <span id="confirmID"></span><br>
                <strong>Opção:</strong> <span id="confirmOption"></span><br>
                <strong>Quantidade:</strong> <span id="confirmSaleAmount"></span><br>
                <strong>Preço Unitário:</strong> R$ <span id="confirmSalePrice"></span><br>
                <strong>Preço Total:</strong> R$ <span id="confirmTotalPrice"></span>
            </p>
            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-danger" id="cancelSaleConfirmation">Cancelar</button>
                <button class="btn btn-success" id="confirmSaleSave">Confirmar</button>
            </div>
        </div>
    </div>


</main>

<script>
    function calculateTotalForSale() {
        const amount = parseFloat(document.getElementById('sale_amount').value) || 0;
        const price = parseFloat(document.getElementById('sale_price').value) || 0;
        const total = amount * price;
        document.getElementById('sale_total_price').value = total.toFixed(2);
    }
    document.getElementById('sale_amount').addEventListener('input', calculateTotalForSale);
    document.getElementById('sale_price').addEventListener('input', calculateTotalForSale);

    document.addEventListener("DOMContentLoaded", () => {
        const confirmationCard = document.getElementById("confirmationCard");
        const confirmationEditCard = document.getElementById("confirmationEditCard");
        const confirmName = document.getElementById("confirmName");
        const confirmID = document.getElementById("confirmID");
        const confirmOption = document.getElementById("confirmOption");
        const confirmCategory = document.getElementById("confirmCategory");
        const confirmAmount = document.getElementById("confirmAmount");
        const confirmPrice = document.getElementById("confirmPrice");
        const confirmTotalPrice = document.getElementById("confirmTotalPrice");

        const handleModalConfirmation = (modalId) => {
            const modal = document.getElementById(modalId);
            const form = modal.querySelector("form");

            if (modalId === 'addProductModal') {

                const name = form.querySelector("#name")?.value || "Não informado";
                const category = form.querySelector("#category")?.selectedOptions[0]?.text || "Não informado";
                const amount = form.querySelector("#amount")?.value || "0";
                const price = form.querySelector("#price")?.value || "0,00";

                confirmName.innerText = name;
                confirmCategory.innerText = category;
                confirmAmount.innerText = amount;
                confirmPrice.innerText = price;

                const bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal) bootstrapModal.hide();

                setTimeout(() => {
                    const backdrops = document.querySelectorAll(".modal-backdrop");
                    backdrops.forEach((backdrop) => backdrop.remove());

                    confirmationCard.classList.remove("d-none");
                    confirmationCard.style.display = "block";
                }, 300);
            } else {

                const id = form.querySelector("#product_id")?.value || "Não informado";
                const option = form.querySelector("#product_option")?.selectedOptions[0]?.text || "Não informado";
                const amount = form.querySelector("#sale_amount")?.value || "0";
                const price = form.querySelector("#sale_price")?.value || "0,00";
                const totalPrice = form.querySelector("#sale_total_price")?.value || "0,00";

                confirmID.innerText = id;
                confirmOption.innerText = option;
                confirmSaleAmount.innerText = amount;
                confirmSalePrice.innerText = price;
                confirmTotalPrice.innerText = totalPrice;

                const bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal) bootstrapModal.hide();

                setTimeout(() => {
                    const backdrops = document.querySelectorAll(".modal-backdrop");
                    backdrops.forEach((backdrop) => backdrop.remove());

                    confirmationEditCard.classList.remove("d-none");
                    confirmationEditCard.style.display = "block";
                }, 300);
            }

        };


        const addProductSaveBtn = document.getElementById("addProductModal").querySelector("#saveProduct");
        const editProductSaveBtn = document.getElementById("editProductModal").querySelector("#saveSaleProduct");

        if (addProductSaveBtn) {
            addProductSaveBtn.addEventListener("click", () => {
                handleModalConfirmation("addProductModal");
            });
        }

        if (editProductSaveBtn) {
            editProductSaveBtn.addEventListener("click", () => {
                handleModalConfirmation("editProductModal");
            });
        }

        document.getElementById("cancelConfirmation").addEventListener("click", () => {
            Swal.fire({
                title: 'Cancelado!',
                text: 'Ação desfeita com sucesso.',
                icon: 'error',
                confirmButtonText: 'Fechar',
            }).then(() => {
                location.reload();
            });
        });
        document.getElementById("confirmSave").addEventListener("click", () => {
            Swal.fire({
                title: 'Produto Salvo!',
                text: 'Seu produto foi salvo com sucesso.',
                icon: 'success',
                confirmButtonText: 'Fechar',
            }).then(() => {
                location.reload();
            });
        });

        document.getElementById("cancelSaleConfirmation").addEventListener("click", () => {
            Swal.fire({
                title: 'Cancelado!',
                text: 'Ação desfeita com sucesso.',
                icon: 'error',
                confirmButtonText: 'Fechar',
            }).then(() => {
                location.reload();
            });
        });
        document.getElementById("confirmSaleSave").addEventListener("click", () => {
            Swal.fire({
                title: 'Ação Concluída!',
                text: 'A venda ou compra foi registrada com sucesso.',
                icon: 'success',
                confirmButtonText: 'Fechar',
            }).then(() => {
                location.reload();
            });
        });
    });
</script>



@endsection