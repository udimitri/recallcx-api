'use client';

import {
  Pagination,
  PaginationGap,
  PaginationList,
  PaginationNext,
  PaginationPage,
  PaginationPrevious,
} from '@/components/pagination'
import { usePathname, useSearchParams } from "next/navigation";

export function SimplePagination({
  pagination,
}: {
  pagination: {
    current_page: number;
    last_page: number;
  },
}) {
  const searchParams = useSearchParams();
  const pathname = usePathname();

  const link = (page: number) => {
    const params = new URLSearchParams(searchParams);
    params.set('page', page.toString());

    return `${pathname}?${params.toString()}`;
  };

  const optionsFactory = () => {
    if (pagination.last_page <= 9) {
      return [...Array(pagination.last_page).keys()].map(page => page + 1);
    }

    return [
      1,

      // conditional dots
      pagination.current_page - 2 > 2
        ? (pagination.current_page - 3 === 2 ? 2 : '...')
        : null,

      // always show current page and the previous two
      pagination.current_page - 2,
      pagination.current_page - 1,
      pagination.current_page,
      pagination.current_page + 1,
      pagination.current_page + 2,

      // conditional dots
      pagination.current_page + 2 < pagination.last_page - 1
        ? (pagination.current_page + 3 === pagination.last_page - 1 ? pagination.last_page - 1 : '...')
        : null,

      pagination.last_page,
    ]
      // filter out duplicates, nulls and nonexistent pages
      .filter((page, index, all): page is '...' | number => {
        if (!page) {
          return false;
        }

        if (page === '...') {
          return true;
        }

        if (typeof page !== 'number') {
          return false;
        }

        return page > 0 && page <= pagination.last_page && all.indexOf(page) === index;
      });
  };

  const pages = optionsFactory();

  return <>
    <Pagination className="mt-6">
      <PaginationPrevious href={pagination.current_page > 1 ? link(pagination.current_page - 1) : null}/>
      <PaginationList>
        {pages.map(page => page === '...'
          ? <PaginationGap key={page}/>
          : <PaginationPage
            key={page}
            href={link(page)}
            current={pagination.current_page === page}
          >{page}</PaginationPage>
        )}
      </PaginationList>
      <PaginationNext href={pagination.current_page < pagination.last_page ? link(pagination.current_page + 1) : null}/>
    </Pagination>
  </>
}