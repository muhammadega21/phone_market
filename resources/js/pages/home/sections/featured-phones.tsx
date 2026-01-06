import ProductCard from '@/components/cards/product-card';
import { show } from '@/routes/brands';
import { detail } from '@/routes/phones';
import { Phone } from '@/types';

const FeaturedPhones = ({ featuredPhones }: { featuredPhones: Phone[] }) => {
    if (featuredPhones.length === 0) {
        return (
            <section className="mt-2">
                <h1 className="section-title">Produk Unggulan</h1>
                <div className="my-4 text-center">
                    <p>Tidak ada data produk unggulan</p>
                </div>
            </section>
        );
    }

    return (
        <section className="mt-2">
            <h1 className="section-title">Produk Unggulan</h1>
            <div className="mt-4 grid grid-cols-3 gap-3">
                {featuredPhones.map((data) => (
                    <ProductCard key={data.id} data={data} brandLink={show(data.brand.slug).url} productLink={detail(data.slug).url} />
                ))}
            </div>
        </section>
    );
};

export default FeaturedPhones;
