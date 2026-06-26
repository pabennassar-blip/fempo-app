/**
 * Servei de configuració del login: obté imatges, versió i altres configuracions.
 */
import { ServeiApi } from './ServeiApi.js';

export class ServeiLoginConfig extends ServeiApi {
    /**
     * Obté la configuració del login.
     * @param {string} key - 'default' o 'chat'
     * @returns {Promise<object>} Configuració del login
     */
    async obtenirConfig(key = 'default') {
        try {
            const resposta = await fetch(`${ServeiApi.URL_BASE}/login/config?key=${key}`, {
                method: 'GET',
                headers: { 'Accept': 'application/json' },
            });

            if (!resposta.ok) {
                return this._obtenirValorsPerDefecte(key);
            }

            const dades = await resposta.json();
            return dades.config;
        } catch (error) {
            console.error('Error al obtenir configuració del login:', error);
            return this._obtenirValorsPerDefecte(key);
        }
    }

    /**
     * Retorna els valors per defecte si l'API falla.
     * @private
     */
    _obtenirValorsPerDefecte(key) {
        const defaults = {
            default: {
                key: 'default',
                image1_path: 'src/logo_govern_illes_balears.png',
                image2_path: null,
                version: '2.0.0',
                login_title: 'INICIAR SESSIÓ',
                login_subtitle: null,
                show_help_text: true,
            },
            chat: {
                key: 'chat',
                image1_path: 'src/logo_govern_illes_balears.png',
                image2_path: null,
                version: '1.0.0',
                login_title: 'Iniciar Sessió',
                login_subtitle: null,
                show_help_text: true,
            },
        };

        return defaults[key] || defaults.default;
    }
}
