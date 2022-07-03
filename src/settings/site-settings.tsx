import { ILFlag } from '@components/icons/ILFlag'
import { SAFlag } from '@components/icons/SAFlag'
import { CNFlag } from '@components/icons/CNFlag'
import { USFlag } from '@components/icons/USFlag'
import { DEFlag } from '@components/icons/DEFlag'
import { ESFlag } from '@components/icons/ESFlag'

export const siteSettings = {
  name: 'Birtelohne',
  description: '',
  author: {
    name: 'Birtelohne',
    websiteUrl: 'https://shop.birtelohne.no',
    address: ''
  },
  logo: {
    url: 'https://birtelohne.no/wp-content/uploads/2022/03/logo-2x-iphone-retina.png',
    alt: 'Birtelohne',
    href: '/',
    width: 95,
    height: 30
  },
  defaultLanguage: 'en',
  currencyCode: 'NOK',
  site_header: {
    menu: [
      { id: 1, path: '/category/grafikk', label: 'Grafikk' },
      { id: 2, path: '/category/malerier', label: 'Malerier' },
      { id: 2, path: '/category/kunstkort', label: 'Kunstkort' },
      { id: 2, path: '/category/keramikk', label: 'Keramikk' }
    ],
    mobileMenu: [
      { id: 1, path: '/category/grafikk', label: 'Grafikk' },
      { id: 2, path: '/category/malerier', label: 'Malerier' },
      { id: 2, path: '/category/kunstkort', label: 'Kunstkort' },
      { id: 2, path: '/category/keramikk', label: 'Keramikk' }
    ],
    languageMenu: [
      {
        id: 'ar',
        name: 'عربى - AR',
        value: 'ar',
        icon: <SAFlag width='20px' height='15px' />
      },
      {
        id: 'zh',
        name: '中国人 - ZH',
        value: 'zh',
        icon: <CNFlag width='20px' height='15px' />
      },
      {
        id: 'en',
        name: 'English - EN',
        value: 'en',
        icon: <USFlag width='20px' height='15px' />
      },
      {
        id: 'de',
        name: 'Deutsch - DE',
        value: 'de',
        icon: <DEFlag width='20px' height='15px' />
      },
      {
        id: 'he',
        name: 'rעברית - HE',
        value: 'he',
        icon: <ILFlag width='20px' height='15px' />
      },
      {
        id: 'es',
        name: 'Español - ES',
        value: 'es',
        icon: <ESFlag width='20px' height='15px' />
      }
    ]
  }
}
