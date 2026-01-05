import BaseLayout from '@/layouts/base-layout';
import { Banner as BannerType, Category, Phone } from '@/types';
import Banner from './sections/banner';
import Categories from './sections/categories';
import FeaturedPhones from './sections/featured-phones';
import PopularPhones from './sections/popular-phones';

interface HomeProps {
    banners: BannerType[];
    categories: Category[];
    featuredPhones: Phone[];
    popularPhones: Phone[];
}

const Home = ({ banners, categories, featuredPhones, popularPhones }: HomeProps) => {
    return (
        <BaseLayout>
            <Banner banners={banners} />
            <Categories categories={categories} />
            <FeaturedPhones featuredPhones={featuredPhones} />
            <PopularPhones popularPhones={popularPhones} />
        </BaseLayout>
    );
};

export default Home;
