(function($) {
    /**
     * Indonesian language package
     * Translated by @egig
     */
    FormValidation.I18n = $.extend(true, FormValidation.I18n, {
        'id_ID': {
            base64: {
                'default': 'Isikan karakter base 64 tersandi yang valid'
            },
            between: {
                'default': 'Isikan nilai antara %s dan %s',
                notInclusive: 'Isikan nilai antara %s dan %s, strictly'
            },
            bic: {
                'default': 'Isikan nomor BIC yang valid'
            },
            callback: {
                'default': 'Isikan nilai yang valid'
            },
            choice: {
                'default': 'Isikan nilai yang valid',
                less: 'Silahkan pilih pilihan %s pada minimum',
                more: 'Silahkan pilih pilihan %s pada maksimum',
                between: 'Silahkan pilih pilihan %s - %s'
            },
            color: {
                'default': 'Isikan karakter warna yang valid'
            },
            creditCard: {
                'default': 'Isikan nomor kartu kredit yang valid'
            },
            cusip: {
                'default': 'Isikan nomor CUSIP yang valid'
            },
            cvv: {
                'default': 'Isikan nomor CVV yang valid'
            },
            date: {
                'default': 'Isikan tanggal yang benar',
                min: 'Isikan tanggal setelah tanggal %s',
                max: 'Isikan tanggal sebelum tanggal %s',
                range: 'Isikan tanggal antara %s - %s'
            },
            different: {
                'default': 'Isikan nilai yang berbeda'
            },
            digits: {
                'default': 'Isikan dengan hanya digit'
            },
            ean: {
                'default': 'Isikan nomor EAN yang valid'
            },
            ein: {
                'default': 'Isikan nomor EIN yang valid'
            },
            emailAddress: {
                'default': 'Isikan alamat email yang valid'
            },
            file: {
                'default': 'Silahkan pilih file yang valid'
            },
            greaterThan: {
                'default': 'Isikan nilai yang lebih besar atau sama dengan %s',
                notInclusive: 'Silahkan is nilai yang lebih besar dari %s'
            },
            grid: {
                'default': 'Silahkan nomor GRId yang valid'
            },
            hex: {
                'default': 'Isikan karakter hexadecimal yang valid'
            },
            iban: {
                'default': 'Isikan nomor IBAN yang valid',
                country: 'Isikan nomor IBAN yang valid dalam %s',
                countries: {
                    AD: 'Andorra',
                    AE: 'Uni Emirat Arab',
                    AL: 'Albania',
                    AO: 'Angola',
                    AT: 'Austria',
                    AZ: 'Azerbaijan',
                    BA: 'Bosnia and Herzegovina',
                    BE: 'Belgia',
                    BF: 'Burkina Faso',
                    BG: 'Bulgaria',
                    BH: 'Bahrain',
                    BI: 'Burundi',
                    BJ: 'Benin',
                    BR: 'Brazil',
                    CH: 'Switzerland',
                    CI: 'Pantai Gading',
                    CM: 'Kamerun',
                    CR: 'Costa Rica',
                    CV: 'Cape Verde',
                    CY: 'Cyprus',
                    CZ: 'Czech',
                    DE: 'Jerman',
                    DK: 'Denmark',
                    DO: 'Republik Dominika',
                    DZ: 'Algeria',
                    EE: 'Estonia',
                    ES: 'Spanyol',
                    FI: 'Finlandia',
                    FO: 'Faroe Islands',
                    FR: 'Francis',
                    GB: 'Inggris',
                    GE: 'Georgia',
                    GI: 'Gibraltar',
                    GL: 'Greenland',
                    GR: 'Yunani',
                    GT: 'Guatemala',
                    HR: 'Kroasia',
                    HU: 'Hungary',
                    IE: 'Irlandia',
                    IL: 'Israel',
                    IR: 'Iran',
                    IS: 'Iceland',
                    IT: 'Italia',
                    JO: 'Jordan',
                    KW: 'Kuwait',
                    KZ: 'Kazakhstan',
                    LB: 'Libanon',
                    LI: 'Liechtenstein',
                    LT: 'Lithuania',
                    LU: 'Luxembourg',
                    LV: 'Latvia',
                    MC: 'Monaco',
                    MD: 'Moldova',
                    ME: 'Montenegro',
                    MG: 'Madagascar',
                    MK: 'Macedonia',
                    ML: 'Mali',
                    MR: 'Mauritania',
                    MT: 'Malta',
                    MU: 'Mauritius',
                    MZ: 'Mozambique',
                    NL: 'Netherlands',
                    NO: 'Norway',
                    PK: 'Pakistan',
                    PL: 'Polandia',
                    PS: 'Palestina',
                    PT: 'Portugal',
                    QA: 'Qatar',
                    RO: 'Romania',
                    RS: 'Serbia',
                    SA: 'Saudi Arabia',
                    SE: 'Swedia',
                    SI: 'Slovenia',
                    SK: 'Slovakia',
                    SM: 'San Marino',
                    SN: 'Senegal',
                    TN: 'Tunisia',
                    TR: 'Turki',
                    VG: 'Virgin Islands, British'
                }
            },
            id: {
                'default': 'Isikan nomor identitas yang valid',
                country: 'Isikan nomor identitas yang valid dalam %s',
                countries: {
                    BA: 'Bosnia and Herzegovina',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CH: 'Switzerland',
                    CL: 'Chile',
                    CN: 'Cina',
                    CZ: 'Czech',
                    DK: 'Denmark',
                    EE: 'Estonia',
                    ES: 'Spanyol',
                    FI: 'Finlandia',
                    HR: 'Kroasia',
                    IE: 'Irlandia',
                    IS: 'Iceland',
                    LT: 'Lithuania',
                    LV: 'Latvia',
                    ME: 'Montenegro',
                    MK: 'Macedonia',
                    NL: 'Netherlands',
                    PL: 'Polandia',
                    RO: 'Romania',
                    RS: 'Serbia',
                    SE: 'Sweden',
                    SI: 'Slovenia',
                    SK: 'Slovakia',
                    SM: 'San Marino',
                    TH: 'Thailand',
                    ZA: 'Africa Selatan'
                }
            },
            identical: {
                'default': 'Isikan nilai yang sama'
            },
            imei: {
                'default': 'Isikan nomor IMEI yang valid'
            },
            imo: {
                'default': 'Isikan nomor IMO yang valid'
            },
            integer: {
                'default': 'Isikan angka yang valid'
            },
            ip: {
                'default': 'Isikan alamat IP yang valid',
                ipv4: 'Isikan alamat IPv4 yang valid',
                ipv6: 'Isikan alamat IPv6 yang valid'
            },
            isbn: {
                'default': 'Slilahkan isi nomor ISBN yang valid'
            },
            isin: {
                'default': 'Isikan ISIN yang valid'
            },
            ismn: {
                'default': 'Isikan nomor ISMN yang valid'
            },
            issn: {
                'default': 'Isikan nomor ISSN yang valid'
            },
            lessThan: {
                'default': 'Isikan nilai kurang dari atau sama dengan %s',
                notInclusive: 'Isikan nilai kurang dari %s'
            },
            mac: {
                'default': 'Isikan MAC address yang valid'
            },
            meid: {
                'default': 'Isikan nomor MEID yang valid'
            },
            notEmpty: {
                'default': 'Wajib diisi'
            },
            numeric: {
                'default': 'Isikan nomor yang valid'
            },
            phone: {
                'default': 'Isikan nomor telepon yang valid',
                country: 'Isikan nomor telepon yang valid dalam %s',
                countries: {
                    AE: 'Uni Emirat Arab',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CN: 'Cina',
                    CZ: 'Czech',
                    DE: 'Jerman',
                    DK: 'Denmark',
                    ES: 'Spanyol',
                    FR: 'Francis',
                    GB: 'Inggris',
                    IN: 'India',
                    MA: 'Maroko',
                    NL: 'Netherlands',
                    PK: 'Pakistan',
                    RO: 'Romania',
                    RU: 'Russia',
                    SK: 'Slovakia',
                    TH: 'Thailand',
                    US: 'Amerika Serikat',
                    VE: 'Venezuela'
                }
            },
            regexp: {
                'default': 'Isikan nilai yang cocok dengan pola'
            },
            remote: {
                'default': 'Isikan nilai yang valid'
            },
            rtn: {
                'default': 'Isikan nomor RTN yang valid'
            },
            sedol: {
                'default': 'Isikan nomor SEDOL yang valid'
            },
            siren: {
                'default': 'Isikan nomor SIREN yang valid'
            },
            siret: {
                'default': 'Isikan nomor SIRET yang valid'
            },
            step: {
                'default': 'Isikan langkah yang benar pada %s'
            },
            stringCase: {
                'default': 'Isikan hanya huruf kecil',
                upper: 'Isikan hanya huruf besar'
            },
            stringLength: {
                'default': 'Isikan nilai dengan panjang karakter yang benar',
                less: 'Isikan kurang dari %s karakter',
                more: 'Isikan lebih dari %s karakter',
                between: 'Isikan antara %s dan %s panjang karakter'
            },
            uri: {
                'default': 'Isikan URI yang valid'
            },
            uuid: {
                'default': 'Isikan nomor UUID yang valid',
                version: 'Isikan nomor versi %s UUID yang valid'
            },
            vat: {
                'default': 'Isikan nomor VAT yang valid',
                country: 'Isikan nomor VAT yang valid dalam %s',
                countries: {
                    AT: 'Austria',
                    BE: 'Belgium',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CH: 'Switzerland',
                    CY: 'Cyprus',
                    CZ: 'Czech',
                    DE: 'Jerman',
                    DK: 'Denmark',
                    EE: 'Estonia',
                    ES: 'Spanyol',
                    FI: 'Finlandia',
                    FR: 'Francis',
                    GB: 'Inggris',
                    GR: 'Yunani',
                    EL: 'Yunani',
                    HU: 'Hungaria',
                    HR: 'Kroasia',
                    IE: 'Irlandia',
                    IS: 'Iceland',
                    IT: 'Italy',
                    LT: 'Lithuania',
                    LU: 'Luxembourg',
                    LV: 'Latvia',
                    MT: 'Malta',
                    NL: 'Belanda',
                    NO: 'Norway',
                    PL: 'Polandia',
                    PT: 'Portugal',
                    RO: 'Romania',
                    RU: 'Russia',
                    RS: 'Serbia',
                    SE: 'Sweden',
                    SI: 'Slovenia',
                    SK: 'Slovakia',
                    VE: 'Venezuela',
                    ZA: 'Afrika Selatan'
                }
            },
            vin: {
                'default': 'Isikan nomor VIN yang valid'
            },
            zipCode: {
                'default': 'Isikan kode pos yang valid',
                country: 'Isikan kode pos yang valid di %s',
                countries: {
                    AT: 'Austria',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CA: 'Kanada',
                    CH: 'Switzerland',
                    CZ: 'Czech',
                    DE: 'Jerman',
                    DK: 'Denmark',
                    ES: 'Spanyol',
                    FR: 'Francis',
                    GB: 'Inggris',
                    IE: 'Irlandia',
                    IN: 'India',
                    IT: 'Italia',
                    MA: 'Maroko',
                    NL: 'Belanda',
                    PL: 'Polandia',
                    PT: 'Portugal',
                    RO: 'Romania',
                    RU: 'Russia',
                    SE: 'Sweden',
                    SG: 'Singapura',
                    SK: 'Slovakia',
                    US: 'Amerika Serikat'
                }
            }
        }
    });
}(jQuery));
