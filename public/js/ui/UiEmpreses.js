/**
 * Renderitza la pestanya d'empreses.
 */
import { escaparHtml } from '../utilitats/Helpers.js';

export class UiEmpreses {
    renderLlista(empreses, opcions = {}) {
        if (opcions.esProfessor) {
            this.renderDashboard(empreses, opcions);
            return;
        }

        const contenidor = document.getElementById('empresesContainer');
        if (!contenidor) return;

        if (empreses.length === 0) {
            contenidor.innerHTML = '<div class="col-12"><div class="alert alert-info text-center" role="alert">No s\'han trobat empreses.</div></div>';
            return;
        }

        contenidor.innerHTML = empreses.map(empresa => `
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0">
                    ${empresa.logo ? `<img src="${empresa.logo_url}" alt="${escaparHtml(empresa.title)}" class="card-img-top p-3" style="max-height: 80px; object-fit: contain;">` : ''}
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold text-dark mb-3">${escaparHtml(empresa.title)}</h5>
                        ${empresa.description ? `<p class="card-text text-muted small mb-3 flex-grow-1">${escaparHtml(empresa.description)}</p>` : ''}
                        ${this._metadadesEmpresa(empresa)}
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                        <a href="empresa-detalls.html?id=${empresa.id}" class="btn btn-primary w-100">Veure Detalls</a>
                    </div>
                </div>
            </div>
        `).join('');
    }

    renderDashboard(empreses, { onNova, onEditar, onEliminar } = {}) {
        const contenidor = document.getElementById('empresesContainer');
        if (!contenidor) return;

        const totalAmbTelefon = empreses.filter(empresa => empresa.telefon).length;
        const totalAmbUbicacio = empreses.filter(empresa => empresa.location).length;
        const totalAmbTutor = empreses.filter(empresa => empresa.empresari?.user?.name || empresa.nom_empresari).length;

        contenidor.innerHTML = `
            <div class="col-12">
                <div class="companies-admin-shell">
                    <div class="companies-admin-toolbar">
                        <div>
                            <h2 class="companies-admin-title">Gestio d'empreses</h2>
                            <span class="companies-admin-subtitle">${empreses.length} registres</span>
                        </div>
                        <button type="button" class="btn btn-dark companies-action-btn" id="btnNovaEmpresa" title="Nova empresa" aria-label="Nova empresa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            <span>Nova empresa</span>
                        </button>
                    </div>

                    <div class="companies-kpi-grid">
                        <div class="companies-kpi"><span>${empreses.length}</span><small>Total</small></div>
                        <div class="companies-kpi"><span>${totalAmbUbicacio}</span><small>Ubicacio</small></div>
                        <div class="companies-kpi"><span>${totalAmbTelefon}</span><small>Telefon</small></div>
                        <div class="companies-kpi"><span>${totalAmbTutor}</span><small>Contacte</small></div>
                    </div>

                    ${empreses.length === 0 ? this._renderBuit() : this._renderTaula(empreses)}
                </div>
            </div>
        `;

        document.getElementById('btnNovaEmpresa')?.addEventListener('click', () => onNova?.());
        contenidor.querySelectorAll('[data-editar-empresa]').forEach(boto => {
            boto.addEventListener('click', () => onEditar?.(boto.dataset.editarEmpresa));
        });
        contenidor.querySelectorAll('[data-eliminar-empresa]').forEach(boto => {
            boto.addEventListener('click', () => onEliminar?.(boto.dataset.eliminarEmpresa));
        });

        this._assegurarModal();
    }

    obrirModal(empresa = null) {
        this._assegurarModal();

        document.getElementById('empresaModalTitle').textContent = empresa ? 'Editar empresa' : 'Nova empresa';
        document.getElementById('empresaId').value = empresa?.id || '';
        document.getElementById('empresaTitle').value = empresa?.title || '';
        document.getElementById('empresaLogo').value = empresa?.logo || '';
        document.getElementById('empresaLocation').value = empresa?.location || '';
        document.getElementById('empresaTelefon').value = empresa?.telefon || '';
        document.getElementById('empresaNomEmpresari').value = empresa?.nom_empresari || '';
        document.getElementById('empresaDescription').value = empresa?.description || '';
        this.mostrarErrors();

        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('empresaModal'));
        modal.show();
    }

    tancarModal() {
        const element = document.getElementById('empresaModal');
        if (!element) return;
        bootstrap.Modal.getInstance(element)?.hide();
    }

    llegirFormulari() {
        const normalitzar = valor => {
            const text = valor.trim();
            return text === '' ? null : text;
        };

        return {
            id: document.getElementById('empresaId').value,
            dades: {
                title: document.getElementById('empresaTitle').value.trim(),
                logo: normalitzar(document.getElementById('empresaLogo').value),
                location: normalitzar(document.getElementById('empresaLocation').value),
                telefon: normalitzar(document.getElementById('empresaTelefon').value),
                nom_empresari: normalitzar(document.getElementById('empresaNomEmpresari').value),
                description: normalitzar(document.getElementById('empresaDescription').value),
            },
        };
    }

    mostrarErrors(errors = {}) {
        const contenidor = document.getElementById('empresaFormErrors');
        if (!contenidor) return;

        const missatges = Object.values(errors).flat();
        if (missatges.length === 0) {
            contenidor.classList.add('d-none');
            contenidor.innerHTML = '';
            return;
        }

        contenidor.classList.remove('d-none');
        contenidor.innerHTML = missatges.map(missatge => `<div>${escaparHtml(missatge)}</div>`).join('');
    }

    setGuardant(guardant) {
        const boto = document.getElementById('btnGuardarEmpresa');
        if (!boto) return;
        boto.disabled = guardant;
        boto.textContent = guardant ? 'Guardant...' : 'Guardar';
    }

    _renderTaula(empreses) {
        return `
            <div class="companies-table-wrap">
                <table class="table align-middle companies-table mb-0">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Ubicacio</th>
                            <th>Telefon</th>
                            <th>Contacte</th>
                            <th class="text-end">Accions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${empreses.map(empresa => `
                            <tr>
                                <td>
                                    <div class="companies-name-cell">
                                        ${empresa.logo_url ? `<img src="${empresa.logo_url}" alt="${escaparHtml(empresa.title)}">` : `<span>${this._inicials(empresa.title)}</span>`}
                                        <div>
                                            <strong>${escaparHtml(empresa.title)}</strong>
                                            <small>${escaparHtml(this._retallar(empresa.description || 'Sense descripcio', 90))}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>${empresa.location ? escaparHtml(empresa.location) : '<span class="text-muted">-</span>'}</td>
                                <td>${empresa.telefon ? escaparHtml(empresa.telefon) : '<span class="text-muted">-</span>'}</td>
                                <td>${escaparHtml(empresa.nom_empresari || empresa.empresari?.user?.name || '-')}</td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="empresa-detalls.html?id=${empresa.id}" class="btn btn-sm btn-outline-secondary" title="Veure detalls" aria-label="Veure detalls">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z"/>
                                            </svg>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-dark" data-editar-empresa="${empresa.id}" title="Editar" aria-label="Editar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zM12.793 5.5 10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.293l6.793-6.793z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-eliminar-empresa="${empresa.id}" title="Eliminar" aria-label="Eliminar">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2H5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h2.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    _renderBuit() {
        return `
            <div class="companies-empty-state">
                <strong>No hi ha empreses</strong>
                <span>Prem el boto de nova empresa per crear el primer registre.</span>
            </div>
        `;
    }

    _assegurarModal() {
        if (document.getElementById('empresaModal')) return;

        document.body.insertAdjacentHTML('beforeend', `
            <div class="modal fade" id="empresaModal" tabindex="-1" aria-labelledby="empresaModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title text-dark text-uppercase fw-semibold" id="empresaModalTitle">Nova empresa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tancar"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" id="empresaId">
                            <div id="empresaFormErrors" class="alert alert-danger d-none" role="alert"></div>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="empresaTitle" class="form-label fw-semibold small text-uppercase text-muted">Nom</label>
                                    <input type="text" class="form-control" id="empresaTitle" maxlength="255" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="empresaLocation" class="form-label fw-semibold small text-uppercase text-muted">Ubicacio</label>
                                    <input type="text" class="form-control" id="empresaLocation" maxlength="255">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="empresaTelefon" class="form-label fw-semibold small text-uppercase text-muted">Telefon</label>
                                    <input type="text" class="form-control" id="empresaTelefon" maxlength="50">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="empresaNomEmpresari" class="form-label fw-semibold small text-uppercase text-muted">Contacte</label>
                                    <input type="text" class="form-control" id="empresaNomEmpresari" maxlength="255">
                                </div>
                                <div class="col-12">
                                    <label for="empresaLogo" class="form-label fw-semibold small text-uppercase text-muted">Logo</label>
                                    <input type="text" class="form-control" id="empresaLogo" maxlength="255" placeholder="logos/empresa.png">
                                </div>
                                <div class="col-12">
                                    <label for="empresaDescription" class="form-label fw-semibold small text-uppercase text-muted">Descripcio</label>
                                    <textarea class="form-control" id="empresaDescription" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel-lar</button>
                            <button type="button" class="btn btn-dark" id="btnGuardarEmpresa">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }

    _metadadesEmpresa(empresa) {
        return `
            ${empresa.location ? `<p class="card-text text-muted small mb-2">${escaparHtml(empresa.location)}</p>` : ''}
            ${empresa.telefon ? `<p class="card-text text-muted small mb-2">${escaparHtml(empresa.telefon)}</p>` : ''}
            ${empresa.nom_empresari ? `<p class="card-text text-muted small mb-2">${escaparHtml(empresa.nom_empresari)}</p>` : ''}
            ${empresa.empresari?.user?.name ? `<p class="card-text text-muted small mb-3">Tutor: ${escaparHtml(empresa.empresari.user.name)}</p>` : ''}
        `;
    }

    _retallar(text, limit) {
        return text.length > limit ? `${text.slice(0, limit - 1)}...` : text;
    }

    _inicials(text) {
        return escaparHtml((text || 'E').trim().slice(0, 2).toUpperCase());
    }
}
