import BaseLayout from '@/layouts/base-layout';
import { Banner as BannerType, Category } from '@/types';
import Banner from './sections/banner';
import Categories from './sections/categories';

interface HomeProps {
    banners: BannerType[];
    categories: Category[];
}

const Home = ({ banners, categories }: HomeProps) => {
    return (
        <BaseLayout>
            <div className="">
                <Banner banners={banners} />
                <Categories categories={categories} />
            </div>
        </BaseLayout>
    );
};

export default Home;
