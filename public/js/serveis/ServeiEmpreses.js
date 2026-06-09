/**
 * Servei per carregar i filtrar empreses.
 */
import { ServeiApi } from './ServeiApi.js';

export class ServeiEmpreses extends ServeiApi {
    /** @type {Array} Totes les empreses carregades. */
    totes = [];

    /**
     * Carrega totes les empreses des de l'API.
     * @returns {Promise<Array>}
     */
    async carregar() {
        this.totes = await this.get('/empreses');
        return this.totes;
    }

    async crear(dades) {
        const resultat = await this.post('/empreses', dades);
        if (resultat.resposta.ok) {
            await this.carregar();
        }
        return resultat;
    }

    async actualitzar(id, dades) {
        const resultat = await this.put(`/empreses/${id}`, dades);
        if (resultat.resposta.ok) {
            await this.carregar();
        }
        return resultat;
    }

    async eliminar(id) {
        const resposta = await this.delete(`/empreses/${id}`);
        if (resposta.ok) {
            this.totes = this.totes.filter(empresa => Number(empresa.id) !== Number(id));
        }
        return resposta;
    }

    cercarPerId(id) {
        return this.totes.find(empresa => Number(empresa.id) === Number(id)) || null;
    }

    reiniciar() {
        this.totes = [];
    }

    /**
     * Filtra les empreses per un text de cerca.
     * @param {string} textCerca
     * @returns {Array}
     */
    filtrar(textCerca) {
        const cerca = textCerca.toLowerCase();
        return this.totes.filter(empresa => {
            const titol = (empresa.title || '').toLowerCase();
            const descripcio = (empresa.description || '').toLowerCase();
            const ubicacio = (empresa.location || '').toLowerCase();
            const telefon = (empresa.telefon || '').toLowerCase();
            const empresari = (empresa.nom_empresari || '').toLowerCase();
            const any = empresa.created_at
                ? new Date(empresa.created_at).getFullYear().toString()
                : '';

            return titol.includes(cerca)
                || descripcio.includes(cerca)
                || ubicacio.includes(cerca)
                || telefon.includes(cerca)
                || empresari.includes(cerca)
                || any.includes(cerca);
        });
    }
}
