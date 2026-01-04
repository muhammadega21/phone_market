import { Banner as BannerType } from '@/types';
import { Link } from '@inertiajs/react';
import 'swiper/css';
import 'swiper/css/pagination';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';
import './banner.css';

interface BannerProps {
    banners: BannerType[];
}

const Banner = ({ banners }: BannerProps) => {
    const BASE_URL = import.meta.env.VITE_API_STORAGE_URL;

    if (banners.length === 0) {
        return (
            <section className="text-center">
                <p>Banner Kosong</p>
            </section>
        );
    }
    return (
        <section>
            <Swiper
                modules={[Autoplay, Pagination]}
                spaceBetween={20}
                slidesPerView={2}
                pagination={{ clickable: true }}
                autoplay={{
                    delay: 2500,
                    disableOnInteraction: false,
                }}
            >
                {banners.map((banner) => (
                    <SwiperSlide>
                        <Link href={banner.url}>
                            <img src={`${BASE_URL}/${banner.image}`} alt="" />
                        </Link>
                    </SwiperSlide>
                ))}
            </Swiper>
        </section>
    );
};

export default Banner;
