export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        business: Business;
    };
};

export type PaginatedResponse<T> = {
  data: T[];
  current_page: number;
  last_page: number;
  from: number;
  to: number;
}

export type DashboardLast7Report = Array<{ day: string, count: number }>;

export type DashboardRowReport = {
  count: number | null,
  change: number | null,
  last7: DashboardLast7Report
}

export type DashboardResponse = {
  business: {
    name: string,
    address: string,
  },
  audience: DashboardRowReport,
  reviews: DashboardRowReport
}

export type Contact = {
  id: number;
  channel: "email" | "phone";
  value: string;
  review_request_sent_at: null | string;
  created_at: string;
  unsubscribed_at: null | string;
}

export type AudienceMetrics = {
  subscribed: number,
  phone: number,
  email: number,
  unsubscribed: number,
}

export type AudienceOverviewResponse = {
  metrics: AudienceMetrics,
  last7: DashboardLast7Report
}

export type Broadcast = {
  id: number;
  status: "created" | "sending" | "finished";
  subject: string;
  message: string;
  send_at: string;
  created_at: string;
}

export type Business = {
  name: string,
  address: string,
  logo: string,
  owner: {
    first_name: string | null,
  }
};

export type ReviewOverviewResponse = {
  business: {
    name: string,
    address: string,
    rating: number | null,
    review_count: number | null,
  },
  last7: DashboardLast7Report
}

export type ReviewRequest = {
  value: string;
  review_request_sent_at: string;
}
