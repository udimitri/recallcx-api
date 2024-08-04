import { InformationCircleIcon } from "@heroicons/react/16/solid";
import React from "react";

export function InfoAlert({
  message,
  link
}: {
  message: React.ReactNode,
  link: React.ReactNode,
}) {
  return (
    <div className="mt-4 mb-8 rounded-md bg-blue-50 p-4">
      <div className="flex">
        <div className="flex-shrink-0">
          <InformationCircleIcon aria-hidden="true" className="h-5 w-5 text-blue-400"/>
        </div>
        <div className="ml-3 flex-1 md:flex md:justify-between">
          <p className="text-sm text-blue-700">{message}</p>
          {link && <p className="mt-3 text-sm md:ml-6 md:mt-0 whitespace-nowrap font-medium text-blue-700 hover:text-blue-600">
            {link}
          </p>}
        </div>
      </div>
    </div>
  )
}