import { STORAGE_URL } from '@/config/env';
import { show } from '@/routes/categories';
import { Category } from '@/types';
import { Link } from '@inertiajs/react';

const Categories = ({ categories }: { categories: Category[] }) => {
    return (
        <section className="mt-2">
            <h1 className="section-title">Kategori</h1>
            <div className="mt-4 grid grid-cols-6 gap-5">
                {categories.map((category) => (
                    <Link
                        href={show(category.slug).url}
                        className="overflow-hidden rounded-xl border border-gray-200 p-4 text-center transition-[border] duration-150 hover:border-gray-400"
                    >
                        <div className="mx-auto h-20 w-20 overflow-hidden rounded-full">
                            <img src={`${STORAGE_URL}/${category.photo}`} alt="" className="h-full w-full object-cover" />
                        </div>
                        <div className="mt-4">
                            <h4>{category.name}</h4>
                        </div>
                    </Link>
                ))}
            </div>
        </section>
    );
};

export default Categories;
