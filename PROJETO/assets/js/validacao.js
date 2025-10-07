
function maskCPF(value) {
        value = value.replace(/\D/g, '').substring(0, 11);
        let formatted = '';
        if (value.length > 0) {
            formatted = value.substring(0, 3);
        }
        if (value.length > 3) {
            formatted += '.' + value.substring(3, 6);
        }
        if (value.length > 6) {
            formatted += '.' + value.substring(6, 9);
        }
        if (value.length > 9) {
            formatted += '-' + value.substring(9, 11);
        }
        return formatted;
    }

function maskCNPJ(value) {
        value = value.replace(/\D/g, '').substring(0, 14);
        let formatted = '';
        if (value.length > 0) {
            formatted = value.substring(0, 2);
        }
        if (value.length > 2) {
            formatted += '.' + value.substring(2, 5);
        }
        if (value.length > 5) {
            formatted += '.' + value.substring(5, 8);
        }
        if (value.length > 8) {
            formatted += '/' + value.substring(8, 12);
        }
        if (value.length > 12) {
            formatted += '-' + value.substring(12, 14);
        }
        return formatted;
    }

function maskTelefone(value) {
        value = value.replace(/\D/g, '').substring(0, 11);
        let formatted = '';
        if (value.length > 0) {
            formatted = '(' + value.substring(0, 2);
        }
        if (value.length > 2) {
            formatted += ') ' + value.substring(2, 7);
        }
        if (value.length > 7) {
            formatted += '-' + value.substring(7, 11);
        }
        return formatted;
}

function maskCEP(value) {
        
        value = value.replace(/\D/g, '');
        
        
        value = value.substring(0, 8);
        
        
        if (value.length > 5) {
            value = value.substring(0, 5) + '-' + value.substring(5);
        }
        
        return value;
}
    