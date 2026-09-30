import { Component } from 'react';
import { t } from '../lib/i18n.js';

/** If a tool ever crashes, show a friendly message instead of a blank box. */
export default class ErrorBoundary extends Component {
    constructor(props) {
        super(props);
        this.state = { error: null };
    }

    static getDerivedStateFromError(error) {
        return { error };
    }

    componentDidCatch(error, info) {
        console.error('Tool error:', error, info?.componentStack);
    }

    render() {
        if (this.state.error) {
            return (
                <div className="error-boundary">
                    <p className="notice notice--error">{t('Sorry, something went wrong with this tool.')}</p>
                    <div className="row">
                        <button type="button" className="btn btn--primary" onClick={() => this.setState({ error: null })}>
                            {t('Try again')}
                        </button>
                        <button type="button" className="btn" onClick={() => window.location.reload()}>
                            {t('Reload the page')}
                        </button>
                    </div>
                </div>
            );
        }
        return this.props.children;
    }
}
