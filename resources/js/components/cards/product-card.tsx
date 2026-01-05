import { STORAGE_URL } from '@/config/env';
import { Phone } from '@/types';
import { rupiah } from '@/utils/currency';
import { Link } from '@inertiajs/react';

interface ProductCardProps {
    data: Phone;
    productLink: string;
    brandLink: string;
}

const ProductCard = ({ data, productLink, brandLink }: ProductCardProps) => {
    return (
        <Link
            href={productLink}
            className="transition-border grid grid-cols-2 items-center rounded-xl border border-gray-200 duration-150 hover:border-gray-400"
        >
            <div className="border-r border-gray-200 px-4 py-3">
                <img src={`${STORAGE_URL}/${data.thumbnail}`} alt="" />
            </div>
            <div className="p-4">
                <h4 className="font-semibold">{data.name}</h4>
                <Link href={brandLink} className="btn btn-outline btn-xs btn-info">
                    {data.brand.name}
                </Link>
                <ul className="mt-1 flex gap-3 text-xs">
                    {data.specifications.slice(0, 3).map((spec) => (
                        <li className="flex flex-col">
                            <span className="font-semibold uppercase">{spec.name}</span>
                            <span className="text-gray-600">{spec.value}</span>
                        </li>
                    ))}
                </ul>
                <p className="mt-1 text-lg font-semibold">{rupiah(data.price)}</p>
            </div>
        </Link>
    );
};

export default ProductCard;
