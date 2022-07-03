import Card from "@components/common/card";
import SectionHeader from "@components/common/section-header";
import Carousel from "@components/ui/carousel/carousel";
import { SwiperSlide } from "swiper/react";
import CardRoundedLoader from "@components/ui/loaders/card-rounded-loader";
import { useBrandsQuery } from "@framework/brand/get-all-brands";
import { ROUTES } from "@utils/routes";
import Alert from "@components/ui/alert";
import { Brand } from "@framework/types";

interface BrandProps {
	sectionHeading: string;
	className?: string;
}

const breakpoints = {
	"1720": {
		slidesPerView: 8,
		spaceBetween: 28,
	},
	"1400": {
		slidesPerView: 7,
		spaceBetween: 28,
	},
	"1025": {
		slidesPerView: 6,
		spaceBetween: 20,
	},
	"768": {
		slidesPerView: 5,
		spaceBetween: 20,
	},
	"500": {
		slidesPerView: 4,
		spaceBetween: 20,
	},
	"0": {
		slidesPerView: 3,
		spaceBetween: 12,
	},
};

const BrandBlock: React.FC<BrandProps> = ({
	className = "mb-11 md:mb-11 lg:mb-12 xl:mb-14 lg:pb-1 xl:pb-0",
	sectionHeading,
}) => {
	const { data, isLoading, error } = useBrandsQuery({
		limit: 8,
	});
	const brands = data?.brands;
	return (
		<div className={className}>
			<SectionHeader sectionHeading={sectionHeading} />

			{error ? (
				<Alert message={error?.message} />
			) : (
				<Carousel
					breakpoints={breakpoints}
					buttonGroupClassName="-mt-4 md:-mt-5 xl:-mt-7"
					autoplay={{
						delay: 4000,
					}}
				>
					{isLoading && !data
						? Array.from({ length: 10 }).map((_, idx) => (
								<SwiperSlide key={idx}>
									<CardRoundedLoader uniqueKey={`category-${idx}`} />
								</SwiperSlide>
						  ))
						: brands?.map((brand: Brand) => (
								<SwiperSlide key={`brand--key${brand.id}`}>
									<Card
										item={brand}
										variant="rounded"
										size="medium"
										href={{
											pathname: ROUTES.SEARCH,
											query: { brand: brand.slug },
										}}
									/>
								</SwiperSlide>
						  ))}
				</Carousel>
			)}
		</div>
	);
};

export default BrandBlock;
