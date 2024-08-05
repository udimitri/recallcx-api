import React from "react";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import {AudienceMetrics, DashboardLast7Report, PageProps, PaginatedResponse, ReviewRequest} from '@/types';
import {GrowthChart} from "@/Pages/Partials/GrowthChart";
import {ArrowUpRightIcon, StarIcon} from "@heroicons/react/16/solid";
import {Button} from "@/NewComponents/components/button";
import {ReviewRequestsTable} from "@/Pages/Reviews/Partials/ReviewRequestsTable";

type BusinessWithRatingData = {
  name: string,
  address: string,
  rating: number | null,
  review_count: number | null,
};

type Props = {
  metrics: AudienceMetrics,
  last7: DashboardLast7Report,
  business: BusinessWithRatingData,
  paginatedContacts: PaginatedResponse<ReviewRequest>
}


function StarRating({rating}: { rating: number }) {
  const wholeStars = Math.floor(rating);
  const emptyStars = 5 - wholeStars - 1;

  return (
    <div className="inline-flex">
      {[...new Array(wholeStars)].map((i) => <StarIcon key={i} className="w-5 text-[#ffbc04]" />)}
      {wholeStars < 5 && (
        <div className="relative">
          <StarIcon className="w-5 text-zinc-200" />
          <div className="absolute top-0 left-0 w-[50%] overflow-hidden">
            <StarIcon className="w-5 text-[#ffbc04]" />
          </div>
        </div>
      )}
      {emptyStars > 0 && [...new Array(emptyStars)].map((i) => <StarIcon key={i} className="w-5 text-zinc-200" />)}
    </div>
  )
}

function BusinessOverviewCard({business}: { business: BusinessWithRatingData }) {
  return (
    <div className="mb-8 flex gap-8 rounded-xl p-4 bg-zinc-100">
      <div className="w-36 h-36 rounded-xl flex flex-col justify-center items-center">
        <img src="/google-my-business-logo.svg" alt="Google Business Profile logo" width={100} height={100} />
      </div>
      <div className="flex items-center gap-4 flex-grow">
        <div className="flex flex-col gap-3">
          <div className="flex flex-col">
            <h2 className="text-2xl font-semibold">{business.name}</h2>
            <p>{business.address}</p>
            <div className="text-zinc-500 mt-2 w-fit flex items-center gap-2 rounded-lg">
              {business.rating && <p className="">{business.rating}</p>}
              {business.rating && <StarRating rating={business.rating} />}
              {business.review_count && <p className="text-zinc-500">({business.review_count} reviews)</p>}
            </div>
          </div>
        </div>
      </div>
      <div className="flex items-center justify-center pr-2">
        <Button outline={true}>
          View on Google
          <ArrowUpRightIcon />
        </Button>
      </div>
    </div>
  );
}

export default function Reviews({auth, business, last7, paginatedContacts}: PageProps<Props>) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Reviews</h2>}
    >
      <Head title="Reviews" />

      <div>
        <BusinessOverviewCard business={business} />

        <p className="text-zinc-500 mb-2 text-sm">Review count - last 7 days</p>
        <div className="mb-12 h-[175px] w-full">
          <GrowthChart data={last7} />
        </div>

        <div className="mb-4 flex items-center justify-between">
          <h1 className="font-semibold text-lg">Review requests</h1>
        </div>
        <ReviewRequestsTable data={paginatedContacts} />
      </div>
    </AuthenticatedLayout>
  );
}
