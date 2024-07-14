import {
    Body,
    Container,
    Head,
    Html,
    Link,
    Button,
    Text,
    Tailwind, Section, Img,
} from "@react-email/components";
import * as React from "react";
import {emailTailwindConf} from "./config";

interface MarketingEmailProps {
    companyName: string;
    unsubscribeUrl: string;
    message: string;
}

export const MarketingEmail = ({companyName, message, unsubscribeUrl}: MarketingEmailProps) => {
    return (
        <Html>
            <Head />
            <Tailwind config={emailTailwindConf}>
                <Body className="bg-white my-auto mx-auto font-sans px-2">
                    <Container className="mt-[40px] mx-auto p-[20px] max-w-[465px]">

                        <Img
                            src="https://recallcx.com/circularchic.png"
                            width="100px"
                            className="mx-auto mt-[20px] mb-[20px]"
                        />
                        <p className="hidden text-center text-lg font-bold mt-[20px] mb-[20px]">CHIC Circular
                            Fashion</p>

                        <div className="rounded-[2rem] overflow-hidden bg-white px-4">
                            <p className="bg-[#E9E9EB] px-4 py-3 rounded-xl text-sm ">
                                {message}
                            </p>
                        </div>
                    </Container>
                    <Container className="text-center text-[#bbbbbb] ">
                        <Text className="leading-none mb-0 text-[12px]">
                            {companyName}
                        </Text>
                        <Text className="leading-none mt-[2px] text-[12px]">
                            12529 102 Ave NW, Edmonton, AB T5N 0M4
                        </Text>
                        <Text className="leading-none mt-0 text-[12px]">
                            If you would like to stop receiving emails, you
                            can <Link href={unsubscribeUrl} className="text-[#bbbbbb] underline">unsubscribe</Link>.
                        </Text>
                    </Container>
                </Body>
            </Tailwind>
        </Html>
    );
};

MarketingEmail.PreviewProps = {
    companyName: "CHIC Circular Fashion",
    message: "Our Spring sale starts NOW! Come visit us in The High Street at 12529 102 Ave NW between June 10-24 to get up to 50% off your purchase.",
    unsubscribeUrl: "http://circularchic.localhost:3000/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20="
} as MarketingEmailProps;

export default MarketingEmail;
