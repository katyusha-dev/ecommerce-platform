import Container from '@components/ui/container'
import Layout from '@components/layout/layout'
import Divider from '@components/ui/divider'
import Instagram from '@components/common/instagram'
import { serverSideTranslations } from 'next-i18next/serverSideTranslations'
import { GetStaticProps } from 'next'
import { homeElegantHeroSlider as banners } from '@framework/static/banner'
import NewArrivalsProductFeed from '@components/product/feeds/new-arrivals-product-feed'
import CollectionBlock from '@containers/collection-block'
import { collectionModernData as collection } from '@framework/static/collection'
import CategoryGridBlock from '@containers/category-grid-block'
import CategoryBlock from '@containers/category-block'
import HeroSlider from '@containers/hero-slider'

export default function Home() {
  // const { openModal, setModalView } = useUI()
  // useEffect(() => {
  //   setModalView('NEWSLETTER_VIEW')
  //   setTimeout(() => {
  //     openModal()
  //   }, 2000)
  // }, [])

  return (
    <>
      <Container>
        <HeroSlider data={banners} variantRounded='default' variant='fullWidth' />
      </Container>
      <Container>
        <CategoryBlock sectionHeading='text-shop-by-category' />
        <CollectionBlock variant='modern' data={collection} />
        <NewArrivalsProductFeed />
        <CategoryGridBlock sectionHeading='text-featured-categories' />
        <Divider />
        <Instagram />
      </Container>
      <Divider className='mb-0' />
    </>
  )
}

Home.Layout = Layout

export const getStaticProps: GetStaticProps = async ({ locale }) => {
  return {
    props: {
      ...(await serverSideTranslations(locale!, [
        'common',
        'forms',
        'menu',
        'footer'
      ]))
    }
  }
}
