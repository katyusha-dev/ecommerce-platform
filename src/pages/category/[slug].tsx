import Container from '@components/ui/container'
import Layout from '@components/layout/layout'
import { ProductGrid } from '@components/product/product-grid'
import { serverSideTranslations } from 'next-i18next/serverSideTranslations'
import { GetServerSideProps } from 'next'
import { useRouter } from 'next/router'

export default function Category() {
  const {
    query: { slug }
  } = useRouter()

  const categoryTitle = slug?.toString().split('-').join('')
  
  return (
    <div className='border-t-2 border-borderBottom'>
      <Container>
        <h2 className='capitalize text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold text-heading p-7 text-center w-full'>
          #{categoryTitle}
        </h2>
        <div className='pb-16 lg:pb-20'>
          <ProductGrid className='3xl:grid-cols-6' />
        </div>
      </Container>
    </div> 
  )
}

Category.Layout = Layout

export const getServerSideProps: GetServerSideProps = async ({ locale }) => {
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
