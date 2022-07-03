import Link from '@components/ui/link'
import cn from 'classnames'
import { siteSettings } from '@settings/site-settings'

const Logo: React.FC<React.AnchorHTMLAttributes<{}>> = ({
  className,
  ...props
}) => {
  return (
    <Link href={siteSettings.logo.href} className={cn('inline-flex focus:outline-none', className)} {...props}>
      <img src='https://birtelohne.no/wp-content/uploads/2022/03/logo-2x-iphone-retina.png' style={{ height: '40px' }} />
    </Link>
  )
}

export default Logo
 