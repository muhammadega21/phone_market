import { STORAGE_URL } from '@/config/env';
import { Banner } from '@/types';
import { Link } from '@inertiajs/react';
import 'swiper/css';
import 'swiper/css/pagination';
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';
import './banner.css';

const Banners = ({ banners }: { banners: Banner[] }) => {
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
                            <img src={`${STORAGE_URL}/${banner.image}`} alt="" />
                        </Link>
                    </SwiperSlide>
                ))}
            </Swiper>
        </section>
    );
};

export default Banners;
